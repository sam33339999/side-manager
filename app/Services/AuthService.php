<?php

namespace App\Services;

use App\Repositories\UserRepository;

class AuthService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {
    }

    public function login(array $credentials): array
    {
        $token = auth()->attempt($credentials);

        if (empty($token)) {
            return [false, null];
        }
        return [true, $token];
    }

    public function register(array $registerData): bool
    {
        return $this->userRepository->createUser(
            username: $registerData['username'],
            password: $registerData['password'],
            name: $registerData['name'],
        );
    }
}
