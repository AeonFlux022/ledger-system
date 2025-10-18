<?php
namespace App\Services\Sms;

use App\Models\SmsLog;

class SmsService
{
  protected $provider;

  public function __construct()
  {
    $driver = config('sms.default', 'android_local');

    switch ($driver) {
      case 'android_local':
        $this->provider = new AndroidSmsProvider();
        break;
      // add other drivers...
      default:
        $this->provider = new AndroidSmsProvider();
    }
  }

  /**
   * send and log
   *
   * @param string $to
   * @param string $message
   * @param array $meta    // loan_id, payment_id etc.
   * @return SmsLog
   */
  public function send(string $to, string $message, array $meta = []): SmsLog
  {
    $log = SmsLog::create([
      'to' => $to,
      'from' => $meta['from'] ?? config('sms.from'),
      'message' => $message,
      'provider' => config('sms.default'),
      'status' => 'queued',
      'loan_id' => $meta['loan_id'] ?? null,
      'payment_id' => $meta['payment_id'] ?? null,
      'provider_response' => null,
    ]);

    $resp = $this->provider->send($to, $message, $meta['from'] ?? null);

    $log->update([
      'provider_message_id' => $resp['body']['messageId'] ?? $resp['body']['message_id'] ?? null,
      'provider_response' => $resp['body'] ?? $resp['raw'],
      'status' => $resp['success'] ? 'sent' : 'failed',
    ]);

    return $log;
  }
}
