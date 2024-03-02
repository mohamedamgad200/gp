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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '809802782669-1vilrbbd1bjap4up96ntqgvl943i3ktl.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8000/api/auth/google/callback',
        // 'redirect' => 'https://gp-pk4hct7q2-a1-h.vercel.app/api/api/auth/google/callback',
    ],

];
