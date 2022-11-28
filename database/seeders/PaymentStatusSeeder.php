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
                'id' => PaymentStatus::PAYMENT_PENDING,
                'name' => [
                    'es' => 'Pendiente',
                    'en' => 'Pending',
                ],
            ],
            [
                'id' => PaymentStatus::PAYMENT_PENDING_APPROVAL,
                'name' => [
                    'es' => 'Pending sellers approval',
                    'en' => 'Pendiente aprobación de vendedor',
                ],
            ],
            [
                'id' => PaymentStatus::PAYMENT_REJECT,
                'name' => [
                    'es' => 'Rechazado',
                    'en' => 'Reject',
                ],
            ],
            [
                'id' => PaymentStatus::PAYMENT_APPROVAL,
                'name' => [
                    'es' => 'Aceptado',
                    'en' => 'Accepted',
                ],
            ],
            [
                'id' => PaymentStatus::PAYMENT_CAPTURED,
                'name' => [
                    'es' => 'Capturado',
                    'en' => 'Captured',
                ],
            ],
            [
                'id' => PaymentStatus::PAYMENT_PAID_OUT,
                'name' => [
                    'es' => 'Pagado',
                    'en' => 'Paid Out',
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
