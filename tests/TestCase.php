<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;
use Styde\Enlighten\Tests\EnlightenSetup;
use Tests\Traits\RegisterRolesAndPermissions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use RegisterRolesAndPermissions;
    use EnlightenSetup;

    public function createAuthenticatedAdmin($data = [])
    {
        $user = $this->createUser($data, [Role::ADMIN]);

        return Sanctum::actingAs($user);
    }

    public function createAuthenticatedSeller($data = [])
    {
        $user = $this->createUser($data, [Role::SELLER]);

        return Sanctum::actingAs($user);
    }

    public function createAuthenticatedUser($data = [])
    {
        $user = $this->createUser($data, [Role::USER]);

        return Sanctum::actingAs($user);
    }

    public function createUser($data = [], array $roles = [])
    {
        $this->registerRolesAndPermissions();

        return User::factory()->withRoles($roles)->create($data);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpEnlighten();
    }
}
