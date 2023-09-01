<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdministratorSeeder;
use Database\Seeders\UserSeeder;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
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

    public function test_create_user(): void
    {
        $response = $this->post('/api/v1/register', [
            'username' => 'user1234',
            'password' => 'user1234',
            'name' => 'user_test',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'status' => 'success',
            ]);
    }

    public function test_create_loss_param(): void
    {
        $response = $this->post('/api/v1/register', []);

        $response->assertStatus(400);
    }
    public function test_create_user_exists(): void
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/api/v1/register', [
            'username' => 'user1234',
            'password' => 'user1234',
            'name' => 'user_test',
        ]);

        $response->assertStatus(400);
    }


    public function test_me(): void
    {
        $user = User::query()->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->get('/api/v1/me', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200);
    }

    public function test_me_no_login(): void
    {
        $response = $this->get('/api/v1/me');
        $response->assertStatus(401);
    }
}
