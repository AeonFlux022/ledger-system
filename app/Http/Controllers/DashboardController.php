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
    $now = Carbon::now();
    $year = request('year', $now->year);

    /* =======================
       Core KPIs
    ======================= */

    $userCount = User::count();
    $borrowerCount = Borrower::count();
    $loanCount = Loan::count();

    $approvedLoans = Loan::where('status', 'approved')->count();
    $rejectedLoans = Loan::where('status', 'rejected')->count();

    $totalLoanAmount = Loan::where('status', 'approved')->sum('loan_amount');

    $totalCollected = Payment::sum('amount');
    $penaltyIncome = Payment::sum('penalty');

    // Interest income
    $interestIncome = Loan::where('status', 'approved')
      ->withSum('payments', 'amount')
      ->get()
      ->sum(fn($loan) => max($loan->payments_sum_amount - $loan->loan_amount, 0));

    $totalEarnings = round($interestIncome + $penaltyIncome, 2);

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



    /* =======================
       Monthly Comparison
    ======================= */

    $currentMonth = $now->month;
    $previousMonth = $now->copy()->subMonth()->month;

    $currentCollected = Payment::whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $now->year)
      ->sum('amount');

    $previousCollected = Payment::whereMonth('created_at', $previousMonth)
      ->whereYear('created_at', $now->copy()->subMonth()->year)
      ->sum('amount');

    $currentIncome = Payment::whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $now->year)
      ->sum('penalty');

    $previousIncome = Payment::whereMonth('created_at', $previousMonth)
      ->whereYear('created_at', $now->copy()->subMonth()->year)
      ->sum('penalty');


    /* =======================
       Yearly Trend (Sparse)
    ======================= */

    // Collections
    $collections = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
      ->whereYear('created_at', $year)
      ->groupBy(DB::raw('MONTH(created_at)'))
      ->pluck('total', 'month');

    // Receivables (interest)
    $receivables = Loan::where('status', 'approved')
      ->whereYear('created_at', $year)
      ->withSum('payments', 'amount')
      ->get()
      ->groupBy(fn($loan) => $loan->created_at->month)
      ->map(
        fn($loans) =>
        $loans->sum(
          fn($loan) =>
          max($loan->payments_sum_amount - $loan->loan_amount, 0)
        )
      );

    // Only months with data
    $labels = [];
    $monthlyCollections = [];
    $monthlyReceivables = [];

    foreach ($collections as $month => $value) {
      $labels[] = Carbon::create()->month($month)->format('M');
      $monthlyCollections[] = $value;
      $monthlyReceivables[] = $receivables[$month] ?? 0;
    }


    return view('pages.admin.dashboard', compact(
      'userCount',
      'borrowerCount',
      'loanCount',
      'approvedLoans',
      'rejectedLoans',
      'topLoanBorrower',
      'topPaymentBorrower',
      'totalLoanAmount',
      'totalCollected',
      'totalEarnings',
      'currentCollected',
      'previousCollected',
      'currentIncome',
      'previousIncome',
      'labels',
      'monthlyCollections',
      'monthlyReceivables',
      'year'
    ));
  }
}
