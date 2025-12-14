<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Services\SmsGatewayService;


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
            'terms' => 'required|in:3,6,9,12',
            'due_date' => 'required|date|after:today',
            'status' => 'in:pending,approved,rejected',
            'loan_status' => 'in:current,overdue,completed'
        ]);

        // Fixed values
        $validated['processing_fee'] = 250;
        $validated['interest_rate'] = 6;

        // Calculate interest
        $interest = $validated['loan_amount'] * ($validated['interest_rate'] / 100) * $validated['terms'];

        // Compute total payable
        $validated['total_payable'] = $validated['loan_amount'] + $interest + $validated['processing_fee'];

        // Monthly amortization
        $validated['monthly_amortization'] = $validated['total_payable'] / $validated['terms'];

        // Overdue (initially zero when loan is created)
        $validated['overdue'] = 0;

        // Outstanding balance (initially the total payable)
        $validated['outstanding_balance'] = $validated['total_payable'];

        // Save loan
        $loan = Loan::create($validated);

        // ✅ Send SMS to borrower upon loan application
        $borrower = $loan->borrower;
        if ($borrower && $borrower->contact_number) {
            $sms = new SmsGatewayService();
            $sms->sendSms(
                $borrower->contact_number,
                "Hi {$borrower->fname}, your loan application of ₱" . number_format($loan->loan_amount, 2) .
                " for {$loan->terms} months has been successfully submitted and is now pending review. " .
                "Thank you for choosing ABG Finance.",
                $loan->id,
                $borrower->id,
                'application'
            );
        }



        $route = auth()->user()->role === 'super_admin'
            ? route('admin.loans.index')
            : route('loans.client', ['borrower' => $validated['borrower_id']]);

        return redirect($route)->with('success', 'Loan applied successfully. Borrower has been notified via SMS.');
    }




    public function show(Loan $loan)
    {
        $loan->load('borrower');


        // calculate overdue penalty dynamically
        $loan->overdue = $loan->calculateOverdues();
        $loan->save();

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

        // update loan status
        $loan->updateLoanStatus();
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

        $borrower = $loan->borrower;

        if ($borrower && $borrower->contact_number) {
            $sms = new SmsGatewayService();
            $sms->sendSms(
                $borrower->contact_number,
                "Hi {$borrower->fname}, your loan application for ₱" . number_format($loan->loan_amount, 2) .
                " has been approved!",
                $loan->id,
                $borrower->id,
                'approval'
            );
        }

        return redirect()
            ->route('admin.loans.index', $loan->id)
            ->with('success', 'Loan approved successfully. Borrower has been notified via SMS.');
    }

    public function decline(Request $request, Loan $loan)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $loan->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        $borrower = $loan->borrower;

        if ($borrower && $borrower->contact_number) {
            $sms = new SmsGatewayService();

            $message =
                "Hi {$borrower->fname}, we regret to inform you that your loan application for ₱" .
                number_format($loan->loan_amount, 2) .
                " has been declined.\n\nReason: {$request->reason}\n\n" .
                "You may reapply once the concern is resolved. Thank you.";

            $sms->sendSms(
                $borrower->contact_number,
                $message,
                $loan->id,
                $borrower->id,
                'decline'
            );
        }

        return redirect()
            ->route('admin.loans.index')
            ->with('success', 'Loan declined and borrower notified with the reason.');
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

        // calculate overdue penalty dynamically
        $loan->overdue = $loan->calculateOverdues();
        $loan->save();

        // Load amortization schedule (from your Loan model method)
        $schedule = $loan->amortizationSchedule();

        // Manual pagination
        $perPage = 6; // you can set 10 if you prefer
        $page = request()->get('page', 1);
        $paginatedSchedule = new LengthAwarePaginator(
            $schedule->forPage($page, $perPage),
            $schedule->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('pages.showSchedule', compact('borrower', 'loan', 'paginatedSchedule'));
    }

    // edit loan in admin panel
    public function update(Request $request, Loan $loan)
    {

        // Prevent editing approved loans
        if ($loan->status === 'approved') {
            return redirect()->back()->with('error', 'Approved loans cannot be edited.');
        }

        $validated = $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'loan_amount' => 'required|numeric|min:1000',
            'terms' => 'required|in:3,6,9,12',
            'due_date' => 'required|date|after:today',
            'status' => 'in:pending,approved,rejected',
            'loan_status' => 'in:current,overdue,completed'
        ]);

        // Fixed values
        $validated['processing_fee'] = 250;
        $validated['interest_rate'] = 6;

        // Recalculate interest
        $interest = $validated['loan_amount'] * ($validated['interest_rate'] / 100) * $validated['terms'];

        // Recompute total payable
        $validated['total_payable'] = $validated['loan_amount'] + $interest + $validated['processing_fee'];

        // Monthly amortization
        $validated['monthly_amortization'] = $validated['total_payable'] / $validated['terms'];

        // Outstanding balance should reset if loan terms are changed
        $validated['outstanding_balance'] = $validated['total_payable'];

        // Update the loan
        $loan->update($validated);

        return redirect()->route('admin.loans.index')->with('success', 'Loan updated successfully.');
    }

    // delete loan in admin panel
    public function destroy(Loan $loan)
    {
        // ❌ Prevent deleting approved or completed loans
        if ($loan->status === 'approved' || $loan->loan_status === 'completed') {
            return redirect()
                ->back()
                ->with('error', 'Approved or completed loans cannot be deleted.');
        }

        // Optional: notify borrower
        // $borrower = $loan->borrower;
        // if ($borrower && $borrower->contact_number) {
        //     $sms = new SmsGatewayService();
        //     $sms->sendSms(
        //         $borrower->contact_number,
        //         "Hi {$borrower->fname}, your loan application has been removed from our system. If this was a mistake, please contact ABG Finance.",
        //         $loan->id,
        //         $borrower->id,
        //         'deleted'
        //     );
        // }

        // Delete loan
        $loan->delete();

        return redirect()
            ->route('admin.loans.index')
            ->with('success', 'Loan deleted successfully.');
    }




}
