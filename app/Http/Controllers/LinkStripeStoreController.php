<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkStripeStoreRequest;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;
use Stripe\Exception\OAuth\OAuthErrorException;
use Symfony\Component\HttpFoundation\Response;

class LinkStripeStoreController extends Controller
{
    /** @throws OAuthErrorException */
    public function __invoke(LinkStripeStoreRequest $request)
    {
        $response = Cashier::stripe()->oauth->token([
            'grant_type' => 'authorization_code',
            'code' => request('authorization_code'),
        ])->toArray();

        $connected_account_id = $response['stripe_user_id'] ?? false;

        if (! $connected_account_id) {
            Log::warning('There was a problem issuing the Stripe token.', [
                'context' => $response,
            ]);

            return response()->noContent(Response::HTTP_BAD_REQUEST);
        }

        auth()->user()->store()->update(['stripe_connect_id' => $connected_account_id]);

        return response()->noContent();
    }
}
