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
      ->paginate(10);

    return view('pages.admin.smsLogs.index', compact('smsLogs'));
  }

}
