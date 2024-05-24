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
