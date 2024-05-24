<?php

namespace App\Actions\Payments;

class CreatePayment
{
    public function handle($session, $event)
    {
        return auth()
            ->user()
            ->payments()
            ->create([
                'event_id' => $event->id,
                'amount' => $session->amount_total,
                'payment_intent' => $session->payment_intent,
                'payment_link' => $session->payment_link,
                'payment_status' => $session->payment_status,
                'currency' => $session->currency,
                'customer' => $session->customer,
            ]);
    }
}
