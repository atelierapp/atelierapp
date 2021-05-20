<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;
use Styde\Enlighten\Tests\EnlightenSetup;
use Tests\Traits\RegisterRolesAndPermissions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use RegisterRolesAndPermissions;
    use EnlightenSetup;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpEnlighten();
    }

    public function createAuthenticatedAdmin($data = [])
    {
        return $this->createAuthenticatedUser($data, [Role::ADMIN]);
    }

    public function createAuthenticatedUser($data = [], $roles = [])
    {
        $user = $this->createUser($data, $roles);

        return Sanctum::actingAs($user);
    }

    public function createUser($data = [], array $roles = [])
    {
        $this->registerRolesAndPermissions();

        return User::factory()->withRoles($roles)->create($data);
    }
}
