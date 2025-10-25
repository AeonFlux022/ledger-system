<?php

namespace App\Http\Controllers;

use App\Models\SmsLog;
use App\Models\Borrower;
use App\Models\Loan;
use Illuminate\Http\Request;

class SmsLogController extends Controller
{
  /**
   * Display all SMS logs
   */
  public function index()
  {
    $smsLogs = SmsLog::with(['borrower', 'loan'])
      ->latest()
      ->paginate(15);

    return view('pages.admin.smsLogs.index', compact('smsLogs'));
  }

  /**
   * Store a new SMS log entry
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'loan_id' => 'nullable|exists:loans,id',
      'borrower_id' => 'required|exists:borrowers,id',
      'phone_number' => 'required|string',
      'message' => 'required|string',
      'success' => 'boolean',
      'response' => 'nullable|string',
      'type' => 'nullable|string',
    ]);

    // Get borrower info for names
    $borrower = Borrower::find($validated['borrower_id']);

    $smsLog = SmsLog::create([
      'loan_id' => $validated['loan_id'] ?? null,
      'borrower_id' => $borrower->id,
      'fname' => $borrower->fname,
      'lname' => $borrower->lname,
      'phone_number' => $validated['phone_number'],
      'message' => $validated['message'],
      'success' => $validated['success'] ?? false,
      'response' => $validated['response'] ?? null,
      'type' => $validated['type'] ?? 'general',
    ]);

    return response()->json([
      'success' => true,
      'message' => 'SMS log stored successfully.',
      'data' => $smsLog,
    ]);
  }
}
