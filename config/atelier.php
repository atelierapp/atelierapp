<?php

return [

    'vendor' => [
        'enabled' => env('ATELIER_VENDOR_ENABLED', false)
    ],

    'web-app' => [

        'redirect' => [
            'stripe' => [
                'connect' => env('ATELIER_VENDOR_REDIRECT_AFTER_CONNECT'),
                'subscription' => [
                    'success' => env('ATELIER_VENDOR_REDIRECT_SUBSCRIPTION_SUCCESS'),
                    'failure' => env('ATELIER_VENDOR_REDIRECT_SUBSCRIPTION_FAILURE'),
                ]
            ]
        ],

    ],

];