<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function any_one_can_access_login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
    /** @test */
    public function an_admin_can_access_the_user_create_page()
    {
        $this->loginAsAdmin();
        $this->get('/users/create')->assertStatus(200);
    }
    /** @test */
    public function user_can_not_access_the_user_create_page()
    {
        $this->loginAsUser();
        $this->get('/users/create')->assertStatus(403); // Unauthorized/Forbidden
    }
    /** @test */
    public function admin_can_create_user()
    {
        $this->loginAsAdmin();
        $userRole = Role::create([
            'name' => 'User',
            'password_rules' => 'min 4 char',
        ]);
        $response = $this->post('/users', [
            'username' => 'username',
            'name' => 'user',
            'lastname' => 'mayandie',
            'email' => 'admin2ee@gmail.com',
            'password' => 'Admin123456',
            'confirm-password' => 'Admin123456',
            'roles' => $userRole->name,
        ]);
        $response->assertStatus(302); //HTTP Status Code 302 - Temporary Redirect
    }
    /** @test */
    public function admin_can_delete_user()
    {
        $this->loginAsAdmin();

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
        $response = $this->delete("/users/{$user->id}");
        $response->assertStatus(200);
    }
}
