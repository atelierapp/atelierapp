<?php

return [

    'vendor' => [
        'enabled' => env('ATELIER_VENDOR_ENABLED', false)
    ],

    'web-app' => [

        'redirect' => [
            'stripe' => [
                'connect' => env('ATELIER_VENDOR_REDIRECT_AFTER_CONNECT'),
                'subscription' => env('ATELIER_VENDOR_REDIRECT_AFTER_SUBSCRIPTION'),
            ]
        ],

    ],

];