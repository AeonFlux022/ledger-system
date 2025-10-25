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
    $approvedLoans = Loan::where('status', 'approved')->count();
    $totalLoanAmount = Loan::sum('loan_amount');

    // ✅ Get total interest earned from all payments
    $interestIncome = Loan::whereHas('payments')->get()->sum(function ($loan) {
      $totalPaid = $loan->payments->sum('amount');
      $principal = $loan->loan_amount;
      return max($totalPaid - $principal, 0); // profit = paid - principal
    });

    // ✅ Get total penalties collected
    $penaltyIncome = Payment::sum('penalty');

    // ✅ Total earnings = interests + penalties
    $totalEarnings = $interestIncome + $penaltyIncome;

    // Optional: round off
    $totalEarnings = round($totalEarnings, 2);

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
