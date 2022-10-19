<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
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
                    'es' => 'Enviado',
                    'en' => 'Send',
                ],
            ],
            [
                'id' => 5,
                'name' => [
                    'es' => 'En tránsito',
                    'en' => 'In Transit',
                ],
            ],
            [
                'id' => 6,
                'name' => [
                    'es' => 'Entregado',
                    'en' => 'Delivered',
                ],
            ],
        ])->each(function ($status) {
            $status = OrderStatus::updateOrCreate([
                'id' => $status['id']
            ], [
                'id' => $status['id'],
                'name' => $status['name'],
            ]);
        });
    }
}
