<?php

use Illuminate\Support\Arr;

function createUUID($length = 6): string
{
    $randomString = '';
    $sequence = 'ABCDEFGHJKLMNPQRSTUVWXYZ123456789';
    $sequenceLength = strlen($sequence);

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, $sequenceLength - 1);
        $randomString .= $sequence[$randomIndex];
    }

    return $randomString;
}

function passwordFromUUID(string $uuid): string
{
    return str(Arr::join(collect(explode('-', $uuid))
        ->map(fn ($section) => $section[3])
        ->toArray(), '')
    )->upper();
}

function createEmptyEvent(): array
{
    return [
        'cover' => [
            'bride' => null,
            'groom' => null,
            'fifteen' => null,
        ],
        'welcome' => [
            'message' => null,
            'visible' => true,
            'message_search' => null,
        ],
        'mentions' => [
            'parents' => [
                'bride' => [
                    'visible' => true,
                    'maleName' => null,
                    'femaleName' => null,
                ],
                'groom' => [
                    'visible' => true,
                    'maleName' => null,
                    'femaleName' => null,
                ],
                'fifteen' => [
                    'visible' => true,
                    'maleName' => null,
                    'femaleName' => null,
                ],
            ],
            'special' => [
                'visible' => true,
                'relatives' => [
                    [
                        'her' => null,
                        'him' => null,
                        'relation' => null,
                    ],
                ],
            ],
        ],
        'locations' => [
            'ceremony' => [
                'name' => null,
                'address' => null,
                'visible' => false,
            ],
            'reception' => [
                'name' => null,
                'address' => null,
            ],
            'ceremonyLocation' => [
                'lat' => 19.432631022767044,
                'lng' => -99.13321157781176,
            ],
            'receptionLocation' => [
                'lat' => 19.432631022767044,
                'lng' => -99.13321157781176,
            ],
        ],
        'dressCode' => [
            'visible' => true,
            'code' => null,
            'colors' => [
                'items' => [],
                'visible' => true,
            ],
        ],
        'program' => [
            'visible' => true,
            'items' => [
                [
                    'time' => null,
                    'name' => null,
                ],
            ],
        ],
        'socials' => [
            'visible' => true,
            'items' => [
                [
                    'red' => 'facebook',
                    'url' => 'https://www.facebook.com/',
                    'hashtag' => 'mis-xv',
                ],
            ],
        ],
        'presents' => [
            'tables' => [
                'visible' => false,
                'items' => [
                    [
                        'url' => null,
                        'name' => null,
                    ],
                ],
            ],
            'account' => [
                'visible' => false,
                'bank' => null,
                'card' => null,
                'beneficiary' => null,
            ],
            'envelope' => false,
        ],
        'gallery' => [
            'visible' => true,
            'items' => [],
        ],
        'recommendations' => [
            'visible' => true,
            'items' => [
                [
                    'map' => null,
                    'name' => null,
                    'place' => null,
                    'address' => null,
                ],
            ],
        ],
        'faqs' => [
            'visible' => true,
            'items' => [
                [
                    'answer' => null,
                    'question' => null,
                ],
            ],
        ],
    ];
}
