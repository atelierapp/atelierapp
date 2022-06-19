<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Stripe\Collection;
use Stripe\Price;
use Stripe\Product;

class PlanSeeder extends Seeder
{
    public function run()
    {
        $plans = Cashier::stripe()->products->all();
        $prices = Cashier::stripe()->prices->all();

        foreach ($plans['data'] as $plan) {
            $price = $this->getPrice($plan->id, $prices);
            /** @var Product $plan */
            Plan::create([
                'key' => Str::kebab($plan->name),
                'name' => $plan->name,
                'price' => $price->unit_amount,
                'description' => $plan->description,
                'stripe_plan_id' => $plan->id,
                'stripe_price_id' => $price->id,
            ]);
        }
    }

    private function getPrice(string $productId, Collection $prices): null|Price
    {
        foreach ($prices as $price) {
            /** @var Price $price */
            if ($price->product === $productId) {
                return $price;
            }
        }
        return null;
    }
}
