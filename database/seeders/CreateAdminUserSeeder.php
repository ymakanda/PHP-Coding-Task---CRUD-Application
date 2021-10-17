<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'Admin',
            'password_rules' => 'min 8 char',
        ]);
        $user = User::create([
            'username' => 'admin',
            'name' => 'Yandiswa',
            'lastname' => 'Makanda',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Admin123456'),
            'is_admin' => true,
            'role_id' => $role->id,
        ]);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
        $role = Role::create([
            'name' => 'User',
            'password_rules' => 'min 4 char',
        ]);
    }
}
