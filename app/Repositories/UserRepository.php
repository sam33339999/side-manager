<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function __construct(
        protected User $entity
    ) {
    }

    public function createUser($username, $password, $name): bool
    {
        $r = $this->entity->newQuery()->where('username', $username)->first();

        if (!empty($r)) {
            return false;
        }
        return (bool)$this->entity->newQuery()->create([
            'username' => $username,
            'password' => Hash::make($password),
            'name' => $name,
        ]);
    }
}
