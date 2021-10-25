<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function loginAsAdmin()
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'password_rules' => 'min 8 char',
        ]);
        $createPermission = Permission::create(['name' => 'role-create']);
        $adminRole->givePermissionTo($createPermission);
        $user = User::factory()->create();
        $user->assignRole($adminRole);

        $this->actingAs($user);

        return $user;
    }
    protected function loginAsUser()
    {
        $userRole = Role::create([
            'name' => 'User',
            'password_rules' => 'min 4 char',
        ]);

        $user = User::create([
            'username' => 'username',
            'name' => 'user',
            'lastname' => 'mayandie',
            'email' => 'admin@gmail.com',
            'password' => 'Admin123456',
            'role_id' => $userRole->id,
            'is_admin' => false,
        ]);
        $user->assignRole($userRole);

        $this->actingAs($user);
        return $user;
    }
}
