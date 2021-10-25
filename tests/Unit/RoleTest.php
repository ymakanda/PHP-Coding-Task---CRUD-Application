<?php

namespace Tests\Unit;

use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function an_admin_can_access_the_create_role_page()
    {
        $this->loginAsAdmin();
        $this->get('/roles/create')->assertStatus(200);
    }
    /** @test */
    public function user_can_not_access_the_create_role_page()
    {
        $this->loginAsUser();
        $this->get('/roles/create')->assertStatus(403);
    }
}
