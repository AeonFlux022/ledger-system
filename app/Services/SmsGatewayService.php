<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\SmsLog;

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

  public function sendSms($phoneNumber, $message, $loanId = null, $borrowerId = null)
  {
    $url = "{$this->baseUrl}/message";
    $message = "{$this->brandName} {$message}";

    $payload = [
      "phoneNumbers" => [$phoneNumber],
      "textMessage" => [
        "text" => $message,
      ],
    ];

    $response = Http::withBasicAuth($this->username, $this->password)
      ->withHeaders(['Content-Type' => 'application/json'])
      ->post($url, $payload);

    $success = $response->successful();
    $responseBody = $response->body();

    // Log in Laravel log
    Log::info('SMS Sent', [
      'loan_id' => $loanId,
      'borrower_id' => $borrowerId,
      'phone_number' => $phoneNumber,
      'status' => $response->status(),
      'body' => $responseBody,
    ]);

    // Log in database
    SmsLog::create([
      'loan_id' => $loanId,
      'borrower_id' => $borrowerId,
      'phone_number' => $phoneNumber,
      'message' => $message,
      'success' => $success,
      'response' => $responseBody,
    ]);

    if ($success) {
      return [
        'success' => true,
        'data' => $response->json(),
      ];
    }

    return [
      'success' => false,
      'error' => $responseBody,
    ];
  }
}
