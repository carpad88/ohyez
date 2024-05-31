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
        'logo' => null,
        'music' => null,
        'welcome' => [
            'message' => null,
            'visible' => true,
            'message_search' => null,
        ],
        'counter' => true,
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
            'godparents' => [
                'male' => null,
                'female' => null,
                'visible' => true,
            ],
        ],
        'locations' => [
            'ceremony' => [
                'name' => null,
                'address' => null,
                'visibility' => false,
            ],
            'reception' => [
                'name' => null,
                'address' => null,
                'visibility' => true,
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
            'code' => null,
            'colors' => [
                'items' => [],
                'visibility' => true,
            ],
        ],
        'program' => [
            'items' => [
                [
                    'url' => null,
                    'item' => null,
                ],
            ],
        ],
        'socials' => [
            [
                'red' => null,
                'url' => null,
                'hashtag' => null,
            ],
        ],
        'presents' => [
            'items' => [
                [
                    'url' => null,
                    'item' => null,
                ],
            ],
            'account' => [
                'bank' => null,
                'card' => null,
                'beneficiary' => null,
            ],
            'envelope' => false,
        ],
        'gallery' => [],
        'recommendations' => [
            [
                'map' => null,
                'name' => null,
                'place' => null,
                'address' => null,
            ],
        ],
        'faqs' => [
            [
                'answer' => null,
                'question' => null,
            ],
        ],
    ];
}
