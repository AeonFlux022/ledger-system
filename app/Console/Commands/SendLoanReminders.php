<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use Carbon\Carbon;
use App\Services\SmsGatewayService;

class SendLoanReminders extends Command
{
    protected $signature = 'loans:send-reminders {--force : Send reminders regardless of due date}';
    protected $description = 'Send SMS reminders before and on the loan due date';

    public function handle()
    {
        $today = Carbon::today();
        $sms = new SmsGatewayService();
        $forceSend = $this->option('force');
        $sentCount = 0;

        // Get all approved loans with borrower & payments
        $loans = Loan::with(['borrower', 'payments'])
            ->where('status', 'approved')
            ->get();

        $this->info("Total loans fetched: " . $loans->count());

        foreach ($loans as $loan) {
            $borrower = $loan->borrower;

            if (!$borrower || !$borrower->contact_number) {
                $this->warn("Skipping loan ID {$loan->id}: No borrower contact number found.");
                continue;
            }

            // Normalize due date and today to start of day
            $dueDate = Carbon::parse($loan->due_date)->startOfDay();
            $daysUntilDue = $today->diffInDays($dueDate, false);

            $this->line("Loan ID {$loan->id}: Today={$today->format('Y-m-d')} | Due={$dueDate->format('Y-m-d')} | Diff={$daysUntilDue}");

            // Skip fully paid loans
            if ($loan->payments->count() >= $loan->terms) {
                $this->line("Loan ID {$loan->id} already fully paid. Skipping...");
                continue;
            }

            $message = null;
            $type = null;

            // FORCE TEST MODE (ignore date range)
            if ($forceSend) {
                $message = "[System Reminder] Hi {$borrower->fname}, your loan {$loan->id} will be due on {$dueDate->format('F j, Y')}. Please disregard if already paid. Thank you!";
                $type = 'test';
                $this->info("FORCE TEST → Sending reminder for Loan {$loan->id}");

                $result = $sms->sendSms(
                    $borrower->contact_number,
                    $message,
                    $loan->id,
                    $borrower->id,
                    $type
                );

                $sentCount++;

                if ($result['success']) {
                    $this->info("Test reminder sent successfully for Loan {$loan->id}");
                } else {
                    $this->error("Failed to send test reminder for Loan {$loan->id}: " . $result['error']);
                }

                // IMPORTANT: Skip normal logic
                continue;
            }

            // Reminder before and on due date (3 → 0)
            if ($daysUntilDue >= 0 && $daysUntilDue <= 3) {
                $message = "Hi {$borrower->fname}, your loan {$loan->id} will be due on {$dueDate->format('F j, Y')}. Please disregard if already paid. Thank you!";
                $this->info("Sending 3-day reminder for Loan {$loan->id} to {$borrower->contact_number}");
            }

            // Reminder for overdue loans ( -1 )
            elseif ($daysUntilDue === -1) {
                $message = "Hi {$borrower->fname}, your loan {$loan->id} was due yesterday ({$dueDate->format('F j, Y')}). Please make your payment to avoid further penalties. Thank you!";
                $type = 'overdue';
            }

            // Log if no reminder is needed today
            else {
                $this->line("⏸No reminder needed for Loan ID {$loan->id} (Diff={$daysUntilDue})");
            }

            // Send SMS if message was set
            if ($message) {
                $result = $sms->sendSms(
                    $borrower->contact_number,
                    $message,
                    $loan->id,
                    $borrower->id,
                    'reminder'
                );

                $sentCount++;

                if ($result['success']) {
                    $this->info("Reminder sent successfully for Loan {$loan->id}");
                } else {
                    $this->error("Failed to send reminder for Loan {$loan->id}: " . $result['error']);
                }
            }
        }

        $this->info("Loan reminders processed. Total sent: {$sentCount}");
    }
}
