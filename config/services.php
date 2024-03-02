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
        'client_id' => '745897157893-g661qslgtkf0f3qdren9dpdt3pe19ide.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://gp-production-ead6.up.railway.app/api/auth/google/callback',
        // 'redirect' => 'https://gp-pk4hct7q2-a1-h.vercel.app/api/api/auth/google/callback',
    ],

];
