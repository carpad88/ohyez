<?php

namespace App\Actions\Auth;

use App\Models\User;

class RegisterNewUser
{
    public function handle(array $data): User
    {
        return User::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'] ?? $data['email'],
                'password' => bcrypt(str()->random(32)),
                'email_verified_at' => now(),
            ]
        );
    }
}
