<?php

namespace Tests\Feature\Profile;

use App\Models\SocialAccount;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class DeleteProfileTest extends TestCase
{
    public function test_a_guess_user_cannot_delete_profile()
    {
        $response = $this->deleteJson(route('profile.destroy'));

        $response->assertStatus(401);
    }

    public function test_an_authenticated_user_can_delete_his_profile()
    {
        $user = $this->createAuthenticatedUser();
        $email = $user->email;
        $this->generateTokens($user);

        $response = $this->deleteJson(route('profile.destroy'));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('personal_access_tokens', ['user_id' => $user->id]);
        $this->assertDatabaseMissing('social_accounts', ['user_id' => $user->id]);
        $this->assertDatabaseMissing('users', ['email' => $email]);
    }

    private function generateTokens(User $user)
    {
        $accessToken = new PersonalAccessToken([
            'name' => $this->faker->word,
            'token' => $this->faker->linuxPlatformToken,
        ]);
        $accessToken->tokenable_type = get_class($user);
        $accessToken->tokenable_id = $user->id;
        $accessToken->save();

        SocialAccount::query()->create([
            'driver' => $this->faker->word,
            'user_id' => $user->id,
            'social_id' => $this->faker->numerify('##########'),
        ]);
    }
}
