<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfilePaymentStoreRequest;
use App\Http\Resources\User\PaymentGatewayUserResource;
use App\Models\PaymentGatewayUser;
use App\Models\Role;

class ProfilePaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Role::SELLER);
    }

    public function store(ProfilePaymentStoreRequest $request)
    {
        $paymentGateway = PaymentGatewayUser::updateOrCreate([
            'user_id' => auth()->id(),
            'payment_gateway_id' => $request->get('payment_gateway_id'),
        ],[
            'properties' => $this->getProperties($request->validated()),
        ]);

        return PaymentGatewayUserResource::make($paymentGateway);
    }

    private function getProperties($request): array
    {
        if ($request['payment_gateway_id'] == 1) {
            return [
                'email' => $request['email'],
            ];
        }

        return [];
    }
}
