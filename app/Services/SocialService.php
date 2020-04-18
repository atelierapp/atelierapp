<?php


namespace App\Services;


use App\Models\SocialAccount;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialService {

    public static function getDetailsFromDriver($driver, $token)
    {
        $method = 'getFrom' . Str::ucfirst($driver);

        return self::$method($token);
    }

    public static function getFromGoogle($token)
    {
        $data = Socialite::driver('google')
            ->stateless()
            ->userFromToken($token);

        return (object) [
            'social_id'  => $data->id,
            'email'      => $data->email,
            'avatar'     => $data->avatar,
            'first_name' => $data->user['given_name'],
            'last_name'  => $data->user['family_name'],
        ];
    }

    public static function getFromFacebook($token)
    {
        $data = Socialite::driver('facebook')
            ->stateless()
            ->scopes(explode(',', \Config::get('services.facebook.scopes')))
            ->fields(explode(',', \Config::get('services.facebook.fields')))
            ->userFromToken($token);

        return (object) [
            'social_id'  => $data->getId(),
            'email'      => $data->getEmail(),
            'avatar'     => $data->avatar_original,
            'first_name' => $data->user['first_name'],
            'last_name'  => $data->user['last_name'],
        ];
    }

    /**
     * @param $socialId
     * @return bool|\App\Models\User
     */
    public static function getUser($socialId)
    {
        $socialAccount = SocialAccount::where('social_id', $socialId)->first();

        if ( ! $socialAccount) {
            return false;
        }

        return $socialAccount->user;
    }
}
