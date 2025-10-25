<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Models\Borrower;
use App\Models\SmsLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\SmsGatewayService;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['loan.borrower'])->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('loan.borrower', function ($q) use ($search) {
                $q->where('fname', 'like', "%{$search}%")
                    ->orWhere('lname', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        $payments = $query->paginate(10);
        return view('pages.admin.payments.index', compact('payments'));
    }

    public function store(Request $request, $loanId)
    {
        $loan = Loan::findOrFail($loanId);

        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:' . $loan->terms,
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        $alreadyPaid = Payment::where('loan_id', $loan->id)
            ->where('month', $validated['month'])
            ->exists();

        if ($alreadyPaid) {
            return back()->withErrors(['month' => 'Payment for this month has already been made.']);
        }

        $dueDate = Carbon::parse($validated['due_date']);
        $penalty = now()->greaterThan($dueDate) ? round($validated['amount'] * 0.03, 2) : 0;
        $totalPaid = $validated['amount'] + $penalty;

        $payment = Payment::create([
            'loan_id' => $loan->id,
            'month' => $validated['month'],
            'amount' => $validated['amount'],
            'penalty' => $penalty,
            'total_paid' => $totalPaid,
            'due_date' => $validated['due_date'],
            'reference_id' => strtoupper(Str::random(10)),
        ]);

        // Update loan balance
        $loan->outstanding_balance -= $totalPaid;
        if ($loan->outstanding_balance <= 0) {
            $loan->outstanding_balance = 0;
            $loan->loan_status = 'completed';
        }
        $loan->save();
        $loan->updateLoanStatus();

        // Send SMS
        $sms = new SmsGatewayService();
        $message = "Hi {$loan->borrower->fname}, we received your payment of ₱{$validated['amount']} " .
            ($penalty > 0 ? "plus ₱{$penalty} penalty " : "") .
            "for Loan #{$loan->id}. Ref: {$payment->reference_id}";

        $response = $sms->sendSms($loan->borrower->contact_number, $message);

        // Log SMS to sms_logs table
        SmsLog::create([
            'loan_id' => $loan->id,
            'borrower_id' => $loan->borrower->id,
            'fname' => $loan->borrower->fname,
            'lname' => $loan->borrower->lname,
            'phone_number' => $loan->borrower->contact_number,
            'message' => $message,
            'success' => $response['success'] ?? true,
            'response' => $response['response'] ?? 'Message logged successfully',
            'type' => 'payment',
        ]);

        // Redirect based on role
        $user = auth()->user();
        if ($user && $user->role === 'super_admin') {
            return redirect()
                ->route('admin.loans.show', $loan->id)
                ->with('success', "Payment recorded successfully! Ref: {$payment->reference_id}");
        }

        if ($user && $user->role === 'admin') {
            return redirect()
                ->route('loans.schedule', [
                    'borrower' => $loan->borrower->id,
                    'loan' => $loan->id,
                ])
                ->with('success', "Payment recorded successfully! Ref: {$payment->reference_id}");
        }

        return back()->with('success', "Payment recorded successfully! Ref: {$payment->reference_id}");
    }

    public function borrowerPayments($borrowerId, $loanId)
    {
        $loan = Loan::with('payments')
            ->where('borrower_id', $borrowerId)
            ->findOrFail($loanId);

        $payments = $loan->payments()->orderBy('created_at', 'desc')->paginate(10);
        $borrower = $loan->borrower;

        return view('pages.showPayments', compact('loan', 'borrower', 'payments'));
    }
}
