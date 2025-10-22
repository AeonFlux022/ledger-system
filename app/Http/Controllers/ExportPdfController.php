<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Borrower;
use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;

class ExportPdfController extends Controller
{
    /**
     * Export all users
     */
    public function exportUsers()
    {
        $users = User::all();
        $pdf = Pdf::loadView('pdf.users', compact('users'))->setPaper('a4', 'landscape');
        return $pdf->download('users-list-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export all borrowers
     */
    public function exportBorrowers()
    {
        $borrowers = Borrower::all();
        $pdf = Pdf::loadView('pdf.borrowers', compact('borrowers'))->setPaper('a4', 'landscape');
        return $pdf->download('borrowers-list-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export all loans
     */
    public function exportLoans()
    {
        $loans = Loan::with('borrower')->get();
        $pdf = Pdf::loadView('pdf.loans', compact('loans'))->setPaper('a4', 'landscape');
        return $pdf->download('loans-list-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export all payments
     */
    public function exportPayments(Request $request)
    {
        $search = $request->get('search');

        $payments = Payment::with(['loan.borrower'])
            ->when($search, function ($query, $search) {
                $query->whereHas('loan.borrower', function ($q) use ($search) {
                    $q->where('fname', 'like', "%{$search}%")
                        ->orWhere('lname', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Optional: Dynamic file name (based on filter or default)
        $fileName = $search
            ? 'payments-' . str_replace(' ', '_', strtolower($search)) . '-' . now()->format('Y-m-d') . '.pdf'
            : 'payments-list-' . now()->format('Y-m-d') . '.pdf';

        $pdf = Pdf::loadView('pdf.payments', compact('payments'))
            ->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }

}
