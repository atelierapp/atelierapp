<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication, RefreshDatabase;

    public function createAuthenticatedUser($data = [])
    {
        return $this->createUser($data);
    }

    public function createUser($data = [], $role = null)
    {
        return Sanctum::actingAs($user = factory(User::class)->create($data));
    }
}
