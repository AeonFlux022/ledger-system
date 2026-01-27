<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrower;
use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function index()
  {
    $userCount = User::count();
    $borrowerCount = Borrower::count();
    $loanCount = Loan::count();

    // Approved / Rejected
    $approvedLoans = Loan::where('status', 'approved')->count();
    $rejectedLoans = Loan::where('status', 'rejected')->count();

    // Total principal released
    $totalLoanAmount = Loan::where('status', 'approved')->sum('loan_amount');

    // Interest earned (only from approved with payments)
    $interestIncome = Loan::where('status', 'approved')
      ->whereHas('payments')
      ->get()
      ->sum(function ($loan) {
        $totalPaid = $loan->payments->sum('amount');
        return max($totalPaid - $loan->loan_amount, 0);
      });

    // Penalty income
    $penaltyIncome = Payment::sum('penalty');

    // Total earnings
    $totalEarnings = round($interestIncome + $penaltyIncome, 2);

    // Total collected (actual cash received)
    $totalCollected = Payment::sum('total_paid');

    // Total income (interest + processing fees)
    $totalIncome = Loan::sum('processing_fee')
      + Loan::sum(DB::raw('total_payable - loan_amount'));

    // Top borrower by loan amount
    $topLoanBorrower = Borrower::select(
      'borrowers.id',
      'borrowers.fname',
      'borrowers.lname',
      DB::raw('SUM(loans.loan_amount) as total_loaned')
    )
      ->join('loans', 'loans.borrower_id', '=', 'borrowers.id')
      ->where('loans.status', 'approved')
      ->groupBy('borrowers.id', 'borrowers.fname', 'borrowers.lname')
      ->orderByDesc('total_loaned')
      ->first();

    // Top borrower by payments
    $topPaymentBorrower = Borrower::select(
      'borrowers.id',
      'borrowers.fname',
      'borrowers.lname',
      DB::raw('SUM(payments.amount) as total_paid')
    )
      ->join('loans', 'loans.borrower_id', '=', 'borrowers.id')
      ->join('payments', 'payments.loan_id', '=', 'loans.id')
      ->where('loans.status', 'approved')
      ->groupBy('borrowers.id', 'borrowers.fname', 'borrowers.lname')
      ->orderByDesc('total_paid')
      ->first();


    // ===== Monthly Comparison =====
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    $previousMonth = Carbon::now()->subMonth()->month;
    $previousYear = Carbon::now()->subMonth()->year;

    // Total Collected (payments)
    $currentCollected = Payment::whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $currentYear)
      ->sum('amount');

    $previousCollected = Payment::whereMonth('created_at', $previousMonth)
      ->whereYear('created_at', $previousYear)
      ->sum('amount');

    // Total Income = interest + penalties
    $currentInterest = Loan::where('status', 'approved')
      ->whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $currentYear)
      ->get()
      ->sum(function ($loan) {
        $paid = $loan->payments->sum('amount');
        return max($paid - $loan->loan_amount, 0);
      });

    $previousInterest = Loan::where('status', 'approved')
      ->whereMonth('created_at', $previousMonth)
      ->whereYear('created_at', $previousYear)
      ->get()
      ->sum(function ($loan) {
        $paid = $loan->payments->sum('amount');
        return max($paid - $loan->loan_amount, 0);
      });

    $currentPenalty = Payment::whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $currentYear)
      ->sum('penalty');

    $previousPenalty = Payment::whereMonth('created_at', $previousMonth)
      ->whereYear('created_at', $previousYear)
      ->sum('penalty');

    $currentIncome = $currentInterest + $currentPenalty;
    $previousIncome = $previousInterest + $previousPenalty;


    return view('pages.admin.dashboard', compact(
      'userCount',
      'borrowerCount',
      'loanCount',
      'approvedLoans',
      'rejectedLoans',
      'totalLoanAmount',
      'totalEarnings',
      'totalCollected',
      'totalIncome',
      'topLoanBorrower',
      'topPaymentBorrower',
      'totalCollected',
      'totalIncome',
      'currentCollected',
      'previousCollected',
      'currentIncome',
      'previousIncome'
    ));
  }
}
