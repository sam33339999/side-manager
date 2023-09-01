<?php

namespace Tests\Unit\Services;

use App\Services\AuthService;
use Database\Seeders\AdministratorSeeder;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->seed(AdministratorSeeder::class);
    }

    public function test_login(): void
    {
        /** @var AuthService $service */
        $service = app(AuthService::class);

        [$success, $accessToken] = $service->login(
            credentials: [
                'username' => config('setting.users.username'),
                'password' => config('setting.users.password'),
            ]
        );


        $this->assertTrue($success);
        $this->assertIsString($accessToken);
    }

    public function test_login_failed(): void
    {
        /** @var AuthService $service */
        $service = app(AuthService::class);

        [$success, $accessToken] = $service->login(
            credentials: [
                'username' => config('setting.users.username'),
                'password' => '',
            ]
        );

        $this->assertFalse($success);
        $this->assertNull($accessToken);
    }
}
