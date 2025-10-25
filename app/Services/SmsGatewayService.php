<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\SmsLog;
use App\Models\Borrower;
use App\Models\Loan;

class SmsGatewayService
{
  protected $baseUrl;
  protected $apiKey;
  protected $deviceId;
  protected $username;
  protected $password;
  protected $brandName = '[ABG Finance]';

  public function __construct()
  {
    $this->baseUrl = rtrim(env('SMS_DEVICE_URL'), '/');
    $this->apiKey = env('SMS_GATEWAY_API_KEY');
    $this->deviceId = env('SMS_GATEWAY_DEVICE_ID', 1);
    $this->username = env('SMS_DEVICE_USERNAME');
    $this->password = env('SMS_DEVICE_PASSWORD');
  }

  /**
   * Send an SMS message and automatically log it in the database.
   *
   * @param string $phoneNumber
   * @param string $message
   * @param int|null $loanId
   * @param int|null $borrowerId
   * @param string|null $type
   * @return array
   */
  public function sendSms($phoneNumber, $message, $loanId = null, $borrowerId = null, $type = 'general')
  {
    $url = "{$this->baseUrl}/message";
    $message = "{$this->brandName} {$message}";

    $payload = [
      "phoneNumbers" => [$phoneNumber],
      "textMessage" => [
        "text" => $message,
      ],
    ];

    // Send the message via API
    $response = Http::withBasicAuth($this->username, $this->password)
      ->withHeaders(['Content-Type' => 'application/json'])
      ->post($url, $payload);

    $success = $response->successful();
    $responseBody = $response->body();

    // Map type keyword to readable label
    $typeLabels = [
      'application' => 'Application',
      'payment' => 'Payment',
      'reminder' => 'Reminders',
      'approval' => 'Approval',
      'decline' => 'Rejection',
    ];

    $typeLabel = $typeLabels[strtolower($type)] ?? 'General';

    // Retrieve borrower info (for fname, lname)
    $borrower = $borrowerId ? Borrower::find($borrowerId) : null;

    if ($borrowerId) {
      $borrower = Borrower::find($borrowerId);
    }

    if (!$borrower) {
      $borrower = Borrower::where('contact_number', $phoneNumber)->first();
    }

    // Try to find related loan
    $loan = null;

    if ($loanId) {
      $loan = Loan::find($loanId);
    } elseif ($borrower) {
      $loan = Loan::where('borrower_id', $borrower->id)->latest()->first();
    }

    // Create SMS Log in database
    SmsLog::create([
      'loan_id' => $loan?->id,
      'borrower_id' => $borrower?->id,
      'fname' => $borrower?->fname ?? 'Unknown',
      'lname' => $borrower?->lname ?? '',
      'phone_number' => $phoneNumber,
      'message' => $message,
      'success' => $success,
      'response' => $responseBody,
      'type' => $typeLabel,
    ]);

    // Log to Laravel log file for debugging
    Log::info('SMS Sent', [
      'loan_id' => $loan?->id,
      'borrower_id' => $borrower?->id,
      'borrower' => $borrower ? "{$borrower->fname} {$borrower->lname}" : 'Unknown',
      'phone_number' => $phoneNumber,
      'type' => $type,
      'status' => $response->status(),
      'body' => $responseBody,
    ]);

    // Return structured response
    return [
      'success' => $success,
      'data' => $success ? $response->json() : null,
      'error' => $success ? null : $responseBody,
    ];
  }
}
