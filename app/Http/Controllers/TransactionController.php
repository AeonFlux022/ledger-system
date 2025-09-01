<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Borrower;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Loan $loan)
    {
        $transactions = Transaction::with('loan')->latest()->paginate(10);
        return view('pages.admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Loan $loan)
    {
        //
        return view('pages.admin.transactions.create', compact('loan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $transaction = new Transaction();
        $transaction->loan_id = $loan->id;
        $transaction->amount = $validated['amount'];
        $transaction->reference_id = $this->generateReferenceId();
        $transaction->save();

        return redirect()->back()->with('success', 'Transaction added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    private function generateReferenceId()
    {
        do {
            $referenceId = Str::random(18);
        } while (Transaction::where('reference_id', $referenceId)->exists());

        return $referenceId;
    }
}
