<?php

return [

    'vendor' => [
        'enabled' => env('ATELIER_VENDOR_ENABLED', false)
    ],

    'web-app' => [

        'url' => env('WEB_APP_URL', 'https://app.atelierapp.com'),

        'redirect' => [
            'stripe' => [
                'connect' => env('ATELIER_VENDOR_REDIRECT_AFTER_CONNECT'),
                'subscription' => env('ATELIER_VENDOR_REDIRECT_AFTER_SUBSCRIPTION'),
            ]
        ],

    ],

];