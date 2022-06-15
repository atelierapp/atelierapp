<?php

return [

    'vendor' => [
        'enabled' => env('ATELIER_VENDOR_ENABLED', false)
    ],

    'web-app' => [

        'url' => env('WEB_APP_URL', 'https://app.atelierapp.com'),

        'redirect_uri_stripe' => env('ATELIER_VENDOR_REDIRECT_AFTER_STRIPE'),
    ],

];