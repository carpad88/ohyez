<?php

use App\Http\Controllers\EventController;
use App\Http\Middleware\EventHasExpired;
use App\Http\Middleware\InvitationIsAuthenticated;
use App\Http\Middleware\RedirectIfInvitationAuthenticated;
use App\Livewire\AuthInvitation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::redirect('/login', '/admin/login')->name('login');

Route::group(['middleware' => EventHasExpired::class], function () {
    Route::get('/invitation/{invitation:code}', AuthInvitation::class)
        ->middleware(RedirectIfInvitationAuthenticated::class)
        ->name('invitation.login');

    Route::get('events/{event}/{invitation:code}/download', [EventController::class, 'downloadTickets'])
        ->middleware(InvitationIsAuthenticated::class)
        ->name('event.download');

    Route::get('events/{event}/{invitation:code}', [EventController::class, 'index'])
        ->middleware(InvitationIsAuthenticated::class)
        ->name('event.index');
});
