<?php

namespace App\Traits\Factories;

trait CountryStateTrait
{
    public function country()
    {
        return $this->state(function (array $attributes) {
            return [
                'country' => config('app.country'),
            ];
        });
    }

    public function us()
    {
        return $this->state(function (array $attributes) {
            return [
                'country' => 'us',
            ];
        });
    }

    public function pe()
    {
        return $this->state(function (array $attributes) {
            return [
                'country' => 'pe',
            ];
        });
    }
}
