<?php

return [
    /*
    |--------------------------------------------------------------------------
    | M-Pesa Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for M-Pesa API integration
    |
    */

    'environment' => env('MPESA_ENVIRONMENT', 'sandbox'), // sandbox or production

    'base_url' => env('MPESA_BASE_URL', 'https://sandbox.safaricom.co.ke'),

    'consumer_key' => env('MPESA_CONSUMER_KEY', 'YcxOumVMqmGQbGDQRHS0J3Th9Xe3ZTAFddiVl3I713bHQRpv'),

    'consumer_secret' => env('MPESA_CONSUMER_SECRET', '65YovQ6oUDWVNTAkt7cmWf6C14xAH2D1mVVDe1AS2zew1IRcIHDIdDgGZsEGVYzT'),

    'business_short_code' => env('MPESA_BUSINESS_SHORT_CODE', '174379'),

    'passkey' => env('MPESA_PASSKEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'),

    'callback_url' => env('MPESA_CALLBACK_URL', env('APP_URL') . '/api/mpesa/callback'),

    'timeout' => env('MPESA_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | M-Pesa URLs
    |--------------------------------------------------------------------------
    |
    | Different URLs for sandbox and production environments
    |
    */

    'urls' => [
        'sandbox' => [
            'base' => 'https://sandbox.safaricom.co.ke',
            'oauth' => '/oauth/v1/generate',
            'stk_push' => '/mpesa/stkpush/v1/processrequest',
            'stk_query' => '/mpesa/stkpushquery/v1/query',
        ],
        'production' => [
            'base' => 'https://api.safaricom.co.ke',
            'oauth' => '/oauth/v1/generate',
            'stk_push' => '/mpesa/stkpush/v1/processrequest',
            'stk_query' => '/mpesa/stkpushquery/v1/query',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    |
    | Default settings for payments
    |
    */

    'currency' => env('MPESA_CURRENCY', 'KES'),

    'transaction_type' => 'CustomerPayBillOnline',

    'account_prefix' => env('MPESA_ACCOUNT_PREFIX', 'CROWN'),

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Security configurations for M-Pesa integration
    |
    */

    'verify_ssl' => env('MPESA_VERIFY_SSL', true),

    'log_requests' => env('MPESA_LOG_REQUESTS', true),

    'log_responses' => env('MPESA_LOG_RESPONSES', true),

    /*
    |--------------------------------------------------------------------------
    | Test Phone Numbers
    |--------------------------------------------------------------------------
    |
    | Valid test phone numbers for sandbox environment
    |
    */

    'test_phones' => [
        '254708374149',
        '254711111111',
        '254722222222',
        '254733333333',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sandbox Defaults
    |--------------------------------------------------------------------------
    |
    | Default values for sandbox testing
    |
    */

    'sandbox' => [
        'consumer_key' => 'YcxOumVMqmGQbGDQRHS0J3Th9Xe3ZTAFddiVl3I713bHQRpv',
        'consumer_secret' => '65YovQ6oUDWVNTAkt7cmWf6C14xAH2D1mVVDe1AS2zew1IRcIHDIdDgGZsEGVYzT',
        'business_short_code' => '174379',
        'passkey' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
        'base_url' => 'https://sandbox.safaricom.co.ke',
    ],

    /*
    |--------------------------------------------------------------------------
    | Production Defaults
    |--------------------------------------------------------------------------
    |
    | Default values for production environment
    | These should be overridden with actual production credentials
    |
    */

    'production' => [
        'consumer_key' => env('MPESA_PROD_CONSUMER_KEY'),
        'consumer_secret' => env('MPESA_PROD_CONSUMER_SECRET'),
        'business_short_code' => env('MPESA_PROD_BUSINESS_SHORT_CODE'),
        'passkey' => env('MPESA_PROD_PASSKEY'),
        'base_url' => 'https://api.safaricom.co.ke',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Rate limiting settings for M-Pesa API calls
    |
    */

    'rate_limit' => [
        'max_requests_per_minute' => env('MPESA_RATE_LIMIT', 10),
        'max_requests_per_hour' => env('MPESA_RATE_LIMIT_HOUR', 100),
    ],

    /*
    |--------------------------------------------------------------------------
    | Retry Settings
    |--------------------------------------------------------------------------
    |
    | Retry configuration for failed requests
    |
    */

    'retry' => [
        'max_attempts' => env('MPESA_RETRY_ATTEMPTS', 3),
        'delay_seconds' => env('MPESA_RETRY_DELAY', 2),
    ],
];
