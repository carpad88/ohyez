<?php

use App\Actions\Auth\RegisterNewUser;
use Illuminate\Support\Facades\Route;
use Logto\Sdk\LogtoClient;

Route::group(['prefix' => 'auth'], function () {

    Route::name('auth.sign-in')
        ->get('/sign-in', function (LogtoClient $client) {
            return redirect($client->signIn(config('app.url').'/auth/callback'));
        });

    Route::name('auth.sign-out')
        ->get('/sign-out', function (LogtoClient $client) {
            auth()->logout();

            return redirect($client->signOut(config('app.url')));
        });

    Route::name('auth.callback')
        ->get('/callback', function (LogtoClient $client, RegisterNewUser $registerNewUser) {
            try {
                $client->handleSignInCallback();
                $userInfo = $client->fetchUserInfo();
            } catch (\Throwable $exception) {
                return $exception;
            }

            $user = $registerNewUser->handle(['email' => $userInfo->email, 'name' => $userInfo->name]);
            auth()->login($user);

            return redirect('/events');
        });
});
