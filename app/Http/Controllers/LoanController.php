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

        $route = auth()->user()->role === 'super_admin'
            ? route('admin.borrowers.index')
            : route('clientLoans', ['borrower' => $validated['borrower_id']]);

        return redirect($route)->with('success', 'Loan applied successfully.');
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


    public function approve(Loan $loan)
    {
        $loan->update(['status' => 'approved']);

        return redirect()->route('admin.loans.index', $loan->id)
            ->with('success', 'Loan approved successfully.');
    }

    public function decline(Loan $loan)
    {
        $loan->update(['status' => 'rejected']);

        return redirect()->route('admin.loans.index', $loan->id)
            ->with('success', 'Loan declined successfully.');
    }

    // show schedule in client side
    public function showSchedule($borrowerId, Loan $loan)
    {
        // Ensure borrower exists
        $borrower = Borrower::findOrFail($borrowerId);

        // Security: make sure the loan belongs to the borrower
        if ($loan->borrower_id !== $borrower->id) {
            abort(403, 'Unauthorized access to loan schedule.');
        }

        // Only allow if loan is approved
        if ($loan->status !== 'approved') {
            return redirect()->back()->with('error', 'This loan is not yet approved.');
        }

        // Load amortization schedule (from your Loan model method)
        $schedule = $loan->amortizationSchedule();

        // Manual pagination
        $perPage = 6; // you can set 10 if you prefer
        $page = request()->get('page', 1);
        $paginatedSchedule = new \Illuminate\Pagination\LengthAwarePaginator(
            $schedule->forPage($page, $perPage),
            $schedule->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('pages.showSchedule', compact('borrower', 'loan', 'paginatedSchedule'));
    }


}
