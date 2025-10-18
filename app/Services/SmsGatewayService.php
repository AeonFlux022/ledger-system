<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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

  public function sendSms($phoneNumber, $message)
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

    Log::info('SMS Gateway Response', [
      'status' => $response->status(),
      'body' => $response->body(),
      'json' => $response->json(),
    ]);

    if ($response->successful()) {
      return [
        'success' => true,
        'data' => $response->json(),
      ];
    }

    return [
      'success' => false,
      'error' => $response->body(),
    ];
  }
}
