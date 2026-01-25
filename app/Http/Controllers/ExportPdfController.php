<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Borrower;
use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
     * Export payments report (daily, weekly, monthly)
     */
    public function exportPaymentsReport(Request $request)
    {
        $type = $request->input('type', 'monthly'); // default monthly
        $date = $request->input('date', now()->format('Y-m-d')); // reference date

        $query = Payment::with(['loan.borrower']);

        // Determine range based on type
        switch ($type) {
            case 'daily':
                $startDate = Carbon::parse($date)->startOfDay();
                $endDate = Carbon::parse($date)->endOfDay();
                $label = Carbon::parse($date)->format('F j, Y');
                break;

            case 'weekly':
                $startDate = Carbon::parse($date)->startOfWeek();
                $endDate = Carbon::parse($date)->endOfWeek();
                $label = Carbon::parse($date)->startOfWeek()->format('F j') . ' - ' . Carbon::parse($date)->endOfWeek()->format('F j, Y');
                break;

            case 'monthly':
            default:
                $startDate = Carbon::parse($date)->startOfMonth();
                $endDate = Carbon::parse($date)->endOfMonth();
                $label = Carbon::parse($date)->format('F Y');
                break;
        }

        // Filter payments within range
        $payments = $query->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        // Totals
        $totalAmount = $payments->sum('amount');
        $totalPenalty = $payments->sum('penalty'); // adjust if your column is 'overdue'
        $grandTotal = $totalAmount + $totalPenalty;

        // Dynamic file name
        $fileName = ucfirst($type) . "_Payments_Report_" . $startDate->format('Ymd') . "_to_" . $endDate->format('Ymd') . ".pdf";

        $pdf = Pdf::loadView('pdf.payments-report', [
            'payments' => $payments,
            'periodLabel' => $label,
            'totalAmount' => $totalAmount,
            'totalPenalty' => $totalPenalty,
            'grandTotal' => $grandTotal,
            'reportType' => $type
        ]);

        return $pdf->setPaper('A4', 'portrait')->download($fileName);
    }

}

