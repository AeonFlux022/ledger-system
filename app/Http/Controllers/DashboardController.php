<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Borrower;

class DashboardController extends Controller
{
  public function index()
  {
    $userCount = User::whereIn('role', ['admin', 'super_admin'])->count();
    $borrowerCount = Borrower::count();

    // Placeholder values
    $approvedLoans = 0;
    $totalIncome = 0;

    return view('pages.admin.dashboard', compact('userCount', 'borrowerCount', 'approvedLoans', 'totalIncome'));
  }
}
