<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class LoanController extends Controller
{
    public function index()
    {
        session(['borrowers_previous_url' => url()->previous()]);

        // Latest loans first, 10 per page
        $loans = Loan::orderBy('created_at', 'desc')->paginate(10);

        // Borrowers for the loan creation modal
        $borrowers = Borrower::orderBy('fname')->get();

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
            'terms' => 'required|in:3,6,9,12', // restrict terms
            'due_date' => 'required|date|after:today',
            'status' => 'in:pending,approved,rejected'
        ]);

        // Apply fixed values
        $validated['processing_fee'] = 250;
        $validated['interest_rate'] = 6;

        Loan::create($validated);

        return redirect()->route('admin.loans.index')
            ->with('success', 'Loan created successfully.');
    }


    public function show(Loan $loan)
    {
        $loan->load('borrower');

        $schedule = $loan->amortizationSchedule();

        // manual pagination
        $perPage = 6;
        $page = request()->get('page', 1);
        $paginatedSchedule = new LengthAwarePaginator(
            $schedule->forPage($page, $perPage),
            $schedule->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('pages.admin.loans.show', compact('loan', 'paginatedSchedule'));
    }

    public function clientLoans($borrowerId)
    {
        $borrower = Borrower::findOrFail($borrowerId);

        // Get all loans for this borrower
        $loans = $borrower->loans()->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.showLoan', compact('borrower', 'loans'));
    }


}
