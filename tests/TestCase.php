<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;
use Tests\Traits\RegisterRolesAndPermissions;

abstract class TestCase extends BaseTestCase
{

    use CreatesApplication;
    use RefreshDatabase;
    use RegisterRolesAndPermissions;

    public function createAuthenticatedUser($data = [])
    {
        return $this->createUser($data);
    }

    public function createAuthenticatedAdmin($data = [])
    {
        return $this->createUser($data, true);
    }

    public function createUser($data = [], $isAdmin = false)
    {
        $this->registerRolesAndPermissions();
        $userFactory = $isAdmin ? User::factory()->withAdminRole() : User::factory();

        return Sanctum::actingAs($userFactory->create($data));
    }
}
