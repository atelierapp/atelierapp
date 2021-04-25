<?php

namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Config\Repository;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialService
{
    /** @var Repository */
    protected Repository $configRepository;

    public function __construct(Repository $repository)
    {
        $this->configRepository = $repository;
    }

    public function getDetailsFromDriver(string $driver, string $token): object
    {
        $provider = (string)Str::of($driver)->ucfirst()->prepend('getFrom');

        return $this->$provider($token);
    }

    /**
     * @param string $socialId
     * @return bool|User
     */
    public function getUser(string $socialId)
    {
        $socialAccount = SocialAccount::where('social_id', $socialId)->first();

        if (! $socialAccount) {
            return false;
        }

        return $socialAccount->user;
    }

    protected function getFromApple(string $token): object
    {
        $data = Socialite::driver('apple')
            ->stateless()
            ->userFromToken($token);

        return (object)[
            'social_id' => $data->id,
            'email' => $data->email,
            'last_name' => $data->name ?? '',
        ];
    }

    protected function getFromFacebook(string $token): object
    {
        $data = Socialite::driver('facebook')
            ->stateless()
            ->scopes(explode(',', $this->configRepository->get('services.facebook.scopes')))
            ->fields(explode(',', $this->configRepository->get('services.facebook.fields')))
            ->userFromToken($token);

        return (object)[
            'social_id' => $data->getId(),
            'email' => $data->getEmail(),
            'avatar' => $data->avatar_original,
            'first_name' => $data->user['first_name'],
            'last_name' => $data->user['last_name'],
        ];
    }

    protected function getFromGoogle(string $token): object
    {
        $data = Socialite::driver('google')
            ->stateless()
            ->userFromToken($token);

        return (object)[
            'social_id' => $data->id,
            'email' => $data->email,
            'avatar' => $data->avatar,
            'first_name' => $data->user['given_name'],
            'last_name' => $data->user['family_name'],
        ];
    }
}
