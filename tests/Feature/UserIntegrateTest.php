<?php

namespace Tests\Feature;

use Database\Seeders\AdministratorSeeder;
use Tests\TestCase;

class UserIntegrateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->seed(AdministratorSeeder::class);
    }

    /**
     * A basic feature test example.
     */
    public function test_login(): void
    {
        $response = $this->post('/api/v1/login', [
            'username' => config('setting.users.username'),
            'password' => config('setting.users.password'),
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'success',
            ]);
    }

    public function test_login_loss_param(): void
    {
        $response = $this->post('/api/v1/login', ['password' => 'mYPass!Wd']);
        $response->assertStatus(400);

        $response = $this->post('/api/v1/login', ['username' => 'administrator']);
        $response->assertStatus(400);

        $response = $this->post('/api/v1/login', []);
        $response->assertStatus(400);
    }

    public function test_login_password_error(): void
    {
        $username = 'administrator';
        $password = 'my_error_password';
        $response = $this->post('/api/v1/login', compact('username', 'password'));

        $response->assertStatus(400);
    }
}
