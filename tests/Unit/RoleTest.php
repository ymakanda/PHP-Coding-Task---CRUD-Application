<?php

namespace Tests\Unit;

use Tests\TestCase;
use Spatie\Permission\Models\Role;

class RoleTest extends TestCase
{
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
}
