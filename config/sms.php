<?php
return [
  'default' => env('SMS_DRIVER', 'android_local'),
  'from' => env('SMS_FROM', 'ABGFINANCE'),
  'drivers' => [
    'android_local' => [
      'url' => env('SMS_DEVICE_URL'),
      'username' => env('SMS_DEVICE_USERNAME'),
      'password' => env('SMS_DEVICE_PASSWORD'),
    ],
    // you can add other providers
  ],
];
