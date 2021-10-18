<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
    /** @test */
    public function an_admin_can_access_the_create_page()
    {
        $this->loginAsAdmin();
        $this->get('/roles/create')->assertStatus(200);
    }
}
