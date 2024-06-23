<?php

namespace App\Http\Controllers;

use App\Actions\Events\CreateEvent;
use App\Actions\Payments\CreatePayment;
use App\Filament\App\Resources\EventResource;
use App\Models\Product;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class CheckoutController extends Controller
{
    public function checkout(Request $request, Product $product)
    {
        return $request->user()->checkout(
            $product->default_price_id,
            [
                'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout-cancel'),
                'metadata' => [
                    'product' => $product->stripe_id,
                ],
            ]
        );
    }

    public function success(Request $request, CreateEvent $createEvent, CreatePayment $createPayment)
    {
        $sessionId = $request->get('session_id');

        if ($sessionId === null) {
            return redirect(EventResource::getUrl());
        }
        $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return redirect(EventResource::getUrl());
        }

        $event = $createEvent->handle(['product' => $session->metadata['product']]);

        $createPayment->handle($session, $event, $session->metadata['product']);

        Notification::make()
            ->title('Pago completado')
            ->body('Tu pago ha sido completado. ¡Gracias!')
            ->success()
            ->send();

        return redirect(EventResource::getUrl('edit', ['record' => $event->id]));
    }

    public function cancel()
    {
        return redirect(EventResource::getUrl());
    }
}
