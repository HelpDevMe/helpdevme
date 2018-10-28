<?php

/**
 * Paypal Confing and Settings
*/

return [
    // Sandbox
    'sandbox' => [
        'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
        'secret' => env('PAYPAL_SANDBOX_SECRET')
    ],

    // Live
    'live' => [
        'client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
        'secret' => env('PAYPAL_LIVE_SECRET')
    ],
    
    // Paypal SDK Configurations

    'settings' => [
        // Mode (live or sandbox)
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        // Connection timeout
        'http.ConnectionTimeOut' => 3000,
        // Logs
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        // Level: DEBUG, INFO, WARN, ERROR
        'log.LogLevel' => 'DEBUG'
    ]
];