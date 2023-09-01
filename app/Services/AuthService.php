<?php

namespace App\Services;

class AuthService {

    public function login(array $credentials): array
    {
        $token = auth()->attempt($credentials);

        if (empty($token)) {
            return [false, null];
        }
        return [true, $token];
    }

}
