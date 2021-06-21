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

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpEnlighten();
    }

    /**
     * @param array $data
     * @return HasApiTokens|Authenticatable
     */
    public function createAuthenticatedUser($data = [])
    {
        return $this->createUser($data, [Role::USER]);
    }

    public function createAuthenticatedAdmin($data = [])
    {
        return $this->createUser($data, [Role::ADMIN]);
    }

    public function createUser($data = [], array $role = [])
    {
        $this->registerRolesAndPermissions();

        return Sanctum::actingAs(User::factory()->withRoles($role)->create($data));
    }
}
