<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InvitationController;
use App\Http\Middleware\EventHasExpired;
use App\Http\Middleware\InvitationIsAuthenticated;
use App\Http\Middleware\RedirectIfInvitationAuthenticated;
use App\Livewire\Invitation\Authenticate;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::redirect('/admin/login', '/login')->name('login');

Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout-success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout-cancel');
Route::get('/checkout/{product:stripe_id}', [CheckoutController::class, 'checkout'])->name('checkout');

Route::group(['middleware' => ['auth', 'can:update,event'], 'prefix' => '/events'], function () {
    Route::get('/{event}/preview', [EventController::class, 'preview'])->name('event.preview');
    Route::get('/{event}/invitations-list/download', [EventController::class, 'downloadInvitationsList'])
        ->name('event.invitations-list-pdf');

    // check assistance
    //    Route::get('/{event:code}/login', AuthEvent::class)->name('event.login');
});

Route::group(['middleware' => EventHasExpired::class], function () {
    Route::get('/invitations/{invitation:uuid}/login', Authenticate::class)
        ->middleware(RedirectIfInvitationAuthenticated::class)
        ->name('invitation.login');

    Route::get('/invitations/{invitation:uuid}/download', [InvitationController::class, 'downloadTickets'])
        ->middleware(InvitationIsAuthenticated::class)
        ->name('event.download');

    Route::get('/invitations/{invitation:uuid}', [InvitationController::class, 'view'])
        ->middleware(InvitationIsAuthenticated::class)
        ->name('invitation.view');
});
