<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    public function run()
    {
        collect([
            [
                'id' => 1,
                'name' => [
                    'es' => 'Pendiente',
                    'en' => 'Pending',
                ],
            ],
            [
                'id' => 2,
                'name' => [
                    'es' => 'Pending sellers approval',
                    'en' => 'Pendiente aprobación de vendedor',
                ],
            ],
            [
                'id' => 3,
                'name' => [
                    'es' => 'Rechazado',
                    'en' => 'Reject',
                ],
            ],
            [
                'id' => 4,
                'name' => [
                    'es' => 'Aceptado',
                    'en' => 'Accepted',
                ],
            ],
        ])->each(function ($status) {
            PaymentStatus::updateOrCreate([
                'id' => $status['id']
            ], [
                'id' => $status['id'],
                'name' => $status['name'],
            ]);
        });
    }
}
