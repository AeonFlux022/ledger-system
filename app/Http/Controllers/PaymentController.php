<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Borrower;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\SmsGatewayService;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $query = Payment::with(['loan.borrower'])->orderBy('created_at', 'desc');

        // 🔍 Filter by borrower name or contact number if search is provided
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
        ]);

        $alreadyPaid = Payment::where('loan_id', $loan->id)
            ->where('month', $validated['month'])
            ->exists();

        if ($alreadyPaid) {
            return back()->withErrors([
                'month' => 'Payment for this month has already been made.'
            ]);
        }

        $payment = Payment::create([
            'loan_id' => $loan->id,
            'month' => $validated['month'],
            'amount' => $validated['amount'],
            'reference_id' => strtoupper(Str::random(10)),
        ]);

        // Update loan balance
        $loan->outstanding_balance -= $validated['amount'];
        if ($loan->outstanding_balance <= 0) {
            $loan->outstanding_balance = 0;
            $loan->status = 'completed';
        }
        $loan->save();

        // ✅ Send SMS
        $sms = new SmsGatewayService();
        $sms->sendSms(
            $loan->borrower->contact_number, // use your DB column for phone number
            "Hi {$loan->borrower->fname}, we received your payment of ₱{$validated['amount']} for Loan #{$loan->id}. Ref: {$payment->reference_id}"
        );

        // update loan status after payment
        $loan = Loan::find($payment->loan_id);
        $loan->updateLoanStatus();

        // ✅ Redirect based on role
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

        $payments = $loan->payments()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $borrower = $loan->borrower;

        return view('pages.showPayments', compact('loan', 'borrower', 'payments'));
    }
}
