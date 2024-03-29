<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Laravel\Cashier\Cashier;
use Laravel\Sanctum\PersonalAccessToken;
use Stripe\Exception\OAuth\OAuthErrorException;

class LinkStripeStoreController extends Controller
{
    /** @throws OAuthErrorException */
    public function __invoke(Request $request)
    {
        if (! request()->query('state') || ! request()->query('code')) {
            return $this->buildFailedResponse();
        }

        $token = PersonalAccessToken::findToken(request('state'));

        if (! $token) {
            return $this->buildFailedResponse();
        }

        $response = Cashier::stripe()->oauth->token([
            'grant_type' => 'authorization_code',
            'code' => request()->query('code'),
        ])->toArray();

        $connectedAccountId = $response['stripe_user_id'] ?? false;

        if (! $connectedAccountId) {
            Log::warning('There was an issue with the code returned by Stripe.', [
                'context' => $response,
            ]);

            return $this->buildFailedResponse('There was an issue with the code returned by Stripe.');
        }

        /** @var User $user */
        $user = $token->tokenable;
        $user->store()->update(['stripe_connect_id' => $connectedAccountId]);

        return $this->buildSuccessfulResponse();
    }

    private function buildSuccessfulResponse()
    {
        return $this->buildRedirectUri(true);
    }

    private function buildFailedResponse()
    {
        return $this->buildRedirectUri(false);
    }

    private function buildRedirectUri(bool $connected)
    {
        return redirect(
            sprintf(
                '%s?connected=%s',
                config('atelier.web-app.redirect.stripe.connect'),
                $connected ? 'true' : 'false',
            )
        );
    }
}
