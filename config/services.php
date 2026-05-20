<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'xendit' => [
        'secret_key' => env('XENDIT_SECRET_KEY'),
        'webhook_token' => env('XENDIT_WEBHOOK_TOKEN'),
        'webhook_ips' => [
            '13.229.219.106',
            '13.250.218.10',
            '18.136.196.166',
            '18.136.216.79',
            '18.139.223.95',
            '52.221.36.198',
            '52.74.8.21',
            '52.77.202.164',
            '54.169.176.134',
            '54.169.186.223',
            '54.254.160.103',
            '54.254.225.163',
            '54.255.138.243',
            '54.255.139.222',
            '54.255.201.218',
            '54.255.234.33',
        ],
    ],

    'fonnte' => [
        'token' => env('FONNTE_TOKEN'),
    ],

    'filament' => [
        'admin_email' => env('FILAMENT_ADMIN_EMAIL'),
    ],

];
