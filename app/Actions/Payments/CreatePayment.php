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
                'amount' => $session->amount_total,
                'payment_intent' => $session->payment_intent,
                'payment_link' => $session->payment_link,
                'payment_status' => $session->payment_status,
                'currency' => $session->currency,
                'customer' => $session->customer,
            ]);
    }
}
