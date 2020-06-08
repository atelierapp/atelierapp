<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;
use Tests\Traits\RegisterRolesAndPermissions;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication, RefreshDatabase, RegisterRolesAndPermissions;

    public function createAuthenticatedUser($data = [])
    {
        return $this->createUser($data);
    }

    public function createAuthenticatedAdmin($data = [])
    {
        return $this->createUser($data, 'admin');
    }

    public function createUser($data = [], $role = null)
    {
        $this->registerRolesAndPermissions();

        return Sanctum::actingAs($user = factory(User::class)->create($data));
    }
}
