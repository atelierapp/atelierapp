<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    /** @test */
    public function create_a_system_user_with_user_role()
    {
        $this->seed(RoleSeeder::class);
        $role = Role::whereName(Role::USER)->first();

        $user = User::factory()->withRoles([Role::USER])->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ]);
        $this->assertDatabaseHas('assigned_roles', [
            'role_id' => $role->id,
            'entity_id' => $user->id,
            'entity_type' => User::class
        ]);
    }

    /** @test */
    public function create_a_system_user_with_admin_role()
    {
        $this->seed(RoleSeeder::class);
        $role = Role::whereName(Role::ADMIN)->first();

        $user = User::factory()->withRoles([Role::ADMIN])->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ]);
        $this->assertDatabaseHas('assigned_roles', [
            'role_id' => $role->id,
            'entity_id' => $user->id,
            'entity_type' => User::class
        ]);
    }

    /** @test */
    public function create_a_system_user_with_admin_and_user_role()
    {
        $this->seed(RoleSeeder::class);

        $user = User::factory()->withRoles([Role::ADMIN, Role::USER])->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ]);
        $this->assertDatabaseHas('assigned_roles', [
            'role_id' => Role::whereName(Role::ADMIN)->first()->id,
            'entity_id' => $user->id,
            'entity_type' => User::class
        ]);
        $this->assertDatabaseHas('assigned_roles', [
            'role_id' => Role::whereName(Role::USER)->first()->id,
            'entity_id' => $user->id,
            'entity_type' => User::class
        ]);
    }
}
