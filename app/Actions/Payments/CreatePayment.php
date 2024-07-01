<?php

namespace App\Actions\Payments;

use App\Models\Product;

class CreatePayment
{
    public function handle($session, $event, $product)
    {
        $product = Product::where('stripe_id', $product)->first();

        return auth()
            ->user()
            ->payments()
            ->create([
                'event_id' => $event->id,
                'product_id' => $product->id,
                'amount' => $session['amount_total'] ?? 0,
                'payment_intent' => $session['payment_intent'],
                'payment_link' => $session['payment_link'] ?? null,
                'payment_status' => $session['payment_status'],
                'currency' => $session['currency'] ?? 'mxn',
                'customer' => $session['customer'],
            ]);
    }
}
