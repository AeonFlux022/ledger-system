<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Borrower;
use App\Models\Loan;

class DashboardController extends Controller
{
  public function index()
  {
    $userCount = User::whereIn('role', ['admin', 'super_admin'])->count();
    $borrowerCount = Borrower::count();
    $loanCount = Loan::count();

    // Sum of all loan amounts
    $totalLoanAmount = Loan::sum('loan_amount');

    // Placeholder values (update later)
    $approvedLoans = Loan::where('status', 'approved')->count();
    $totalIncome = 0; // we can update this later with interest + processing fees

    return view('pages.admin.dashboard', compact(
      'userCount',
      'borrowerCount',
      'approvedLoans',
      'loanCount',
      'totalIncome',
      'totalLoanAmount'
    ));
  }
}
