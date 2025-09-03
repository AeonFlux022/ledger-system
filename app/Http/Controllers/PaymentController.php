<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentController extends Controller
{
    public function index()
    {
        // Get all payments with their loan + borrower details
        $payments = Payment::with(['loan.borrower'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
            'reference_id' => strtoupper(Str::random(10)), // Unique ref ID
        ]);

        // Update Loan Outstanding Balance
        $loan->outstanding_balance -= $validated['amount'];

        // Optional: mark loan as completed when fully paid
        if ($loan->outstanding_balance <= 0) {
            $loan->outstanding_balance = 0;
            $loan->status = 'completed';
        }

        $loan->save();

        return redirect()
            ->route('admin.loans.show', $loan->id)
            ->with('success', "Payment recorded successfully! Ref: {$payment->reference_id}");
    }
}
