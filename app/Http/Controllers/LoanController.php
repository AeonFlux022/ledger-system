<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('borrower')->paginate(10);
        $borrowers = Borrower::all();
        return view('pages.admin.loans.index', compact('loans', 'borrowers'));
    }

    public function create()
    {
        $borrowers = Borrower::all();
        return view('pages.admin.loans.create', compact('loans', 'borrowers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'loan_amount' => 'required|numeric|min:1000',
            'interest_rate' => 'required|numeric|min:0',
            'terms' => 'required|integer|min:1',
            'processing_fee' => 'nullable|numeric|min:0',
            'due_date' => 'required|date|after:today',
            'status' => 'in:pending,approved,rejected'
        ]);

        Loan::create($validated);

        return redirect()->route('admin.loans.index')
            ->with('success', 'Loan created successfully.');
    }
}
