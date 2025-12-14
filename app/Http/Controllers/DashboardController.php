<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrower;
use App\Models\Loan;
use App\Models\Payment;

class DashboardController extends Controller
{
  public function index()
  {
    $userCount = User::count();
    $borrowerCount = Borrower::count();
    $loanCount = Loan::count();

    // Approved loans only
    $approvedLoans = Loan::where('status', 'approved')->count();
    $totalLoanAmount = Loan::where('status', 'approved')->sum('loan_amount');

    // Interest earned
    $interestIncome = Loan::where('status', 'approved')
      ->whereHas('payments')
      ->get()
      ->sum(function ($loan) {
        $totalPaid = $loan->payments->sum('amount');
        $principal = $loan->loan_amount;
        return max($totalPaid - $principal, 0);
      });

    // Penalties
    $penaltyIncome = Payment::sum('penalty');

    // Total earnings
    $totalEarnings = round($interestIncome + $penaltyIncome, 2);

    return view('pages.admin.dashboard', compact(
      'userCount',
      'borrowerCount',
      'loanCount',
      'approvedLoans',
      'totalLoanAmount',
      'totalEarnings'
    ));
  }

}
