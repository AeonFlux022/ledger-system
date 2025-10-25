<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StatementController extends Controller
{
  public function show(Borrower $borrower)
  {
    $borrower->load(['loans.payments']); // eager load relationships

    return view('pages.showStatement', compact('borrower'));
  }

  public function exportPdf(Borrower $borrower)
  {
    $borrower->load(['loans.payments']);

    $pdf = Pdf::loadView('pages.statementPdf', compact('borrower'))
      ->setPaper('A4', 'portrait');

    return $pdf->download("SOA_{$borrower->lname}_{$borrower->fname}.pdf");
  }
}
