<?php

namespace App\Listeners;

use App\Exceptions\CustomerNotFoundException;
use App\Exceptions\LinkedStoreNotFoundException;
use App\Models\Store;
use App\Models\User;
use Laravel\Cashier\Events\WebhookReceived;
use Throwable;

class StripeEventListener
{
    /** @throws Throwable */
    public function handle(WebhookReceived $event): void
    {
        match ($event->payload['type']) {
            'customer.subscription.created',
            'customer.subscription.updated', => $this->updateStoreMode($event->payload['data']['object']),
            default => null,
        };
    }

    /** @throws Throwable */
    private function updateStoreMode(array $data): void
    {
        throw_if(! isset($data['customer']), CustomerNotFoundException::class);

        $store = User::firstWhere(['stripe_id' => $data['customer']])->store ?? null;
        throw_if(is_null($store), LinkedStoreNotFoundException::class);

        $store->update(['vendor_mode' => Store::VENDOR_MODE_SUBSCRIPTION]);
    }
}
