<?php
namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class AndroidSmsProvider implements SmsProviderInterface
{
  protected string $baseUrl;
  protected string $username;
  protected string $password;

  public function __construct()
  {
    $cfg = config('sms.drivers.android_local');
    $this->baseUrl = rtrim($cfg['url'] ?? '', '/');
    $this->username = $cfg['username'] ?? null;
    $this->password = $cfg['password'] ?? null;
  }

  /**
   * Send payload to device local server
   *
   * The device expects JSON like:
   * { "textMessage": { "text": "Hello" }, "phoneNumbers": ["+63..."] }
   */
  public function send(string $to, string $message, ?string $from = null): array
  {
    $url = $this->baseUrl . '/message'; // as per the app's local server API
    $payload = [
      'textMessage' => ['text' => $message],
      'phoneNumbers' => is_array($to) ? $to : [$to],
      // optionally you can pass sendFrom or sim index depending on app features
    ];

    try {
      $response = Http::withBasicAuth($this->username, $this->password)
        ->timeout(10)
        ->post($url, $payload);

      // normalize response
      return [
        'success' => $response->ok(),
        'status' => $response->status(),
        'body' => $response->json(),
        'raw' => $response->body(),
      ];
    } catch (RequestException $e) {
      return [
        'success' => false,
        'status' => $e->getCode() ?: 0,
        'body' => null,
        'raw' => $e->getMessage(),
      ];
    }
  }
}
