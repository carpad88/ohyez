<?php

return [
    'admin_password' => env('ADMIN_PASSWORD', 'password'),

    'tiers' => [
        [
            'name' => 'Basic',
            'key' => 'basic',
            'priceId' => env('TIER_1'),
        ],
        [
            'name' => 'Medium',
            'key' => 'medium',
            'priceId' => env('TIER_2'),
        ],
        [
            'name' => 'Pro',
            'key' => 'pro',
            'priceId' => env('TIER_3'),
        ],
    ],

];
