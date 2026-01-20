<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Carbon\Carbon;
use App\Services\SmsGatewayService;
use Illuminate\Http\Request;

class LoanReminderController extends Controller
{
  public function send(Request $request)
  {
    $today = Carbon::today();
    $sms = new SmsGatewayService();
    $sentCount = 0;

    $force = $request->boolean('force');

    $loans = Loan::with(['borrower', 'payments'])
      ->where('status', 'approved')
      ->get();

    foreach ($loans as $loan) {
      $borrower = $loan->borrower;

      if (!$borrower || !$borrower->contact_number) {
        continue;
      }

      // Skip fully paid loans
      if ($loan->payments->count() >= $loan->terms) {
        continue;
      }

      $dueDate = Carbon::parse($loan->due_date)->startOfDay();
      $daysUntilDue = $today->diffInDays($dueDate, false);

      $message = null;
      $type = null;

      // FORCE LOGIC
      if ($force) {
        $message = "Hi {$borrower->fname}, your loan {$loan->id} with loan amount of {$loan->monthly_amortization} and interest of {$loan->overdue} is due on {$dueDate->format('F j, Y')}. Please disregard if already paid. Thank you!";
        $type = 'forced';
      }


      // NORMAL RANGE LOGIC
      else {
        if ($daysUntilDue >= 0 && $daysUntilDue <= 3) {
          $message = "Hi {$borrower->fname}, your loan {$loan->id} with loan amount of {$loan->monthly_amortization} and interest of {$loan->overdue} is due on {$dueDate->format('F j, Y')}. Please disregard if already paid. Thank you!";
          $type = 'reminder';
        } elseif ($daysUntilDue === -5) {
          $message = "Hi {$borrower->fname}, your loan {$loan->id} was due on ({$dueDate->format('F j, Y')}). Please make your payment to avoid further penalties. Thank you!";
          $type = 'overdue';
        }
      }

      if ($message) {
        $sms->sendSms(
          $borrower->contact_number,
          $message,
          $loan->id,
          $borrower->id,
          $type
        );

        $sentCount++;
      }
    }

    return back()->with(
      'success',
      "Loan reminders sent successfully. Total messages sent: {$sentCount}"
    );
  }
}
