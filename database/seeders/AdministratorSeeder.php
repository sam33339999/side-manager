<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::query()->where('username', config('setting.users.username'))->first();

        if ($admin) {
            $this->command->info('*** Administrator account already exists. ***');
            return;
        }

        User::factory()->create([
            'username' => config('setting.users.username'),
            'password' => config('setting.users.password'),
            'name' => '超級管理員',
            'email' => 'admin@localhost',
            'email_verified_at' => null,
            'remember_token' => null,
        ]);
    }
}
