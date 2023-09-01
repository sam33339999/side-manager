<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $service
    ) {}

    public function login(LoginRequest $req): JsonResponse
    {
        if (!empty($req->getErrors())) {
            return $this->failResponse($req->getErrors(), 400);
        }

        [$success, $accessToken] = $this->service->login($req->only(['username', 'password']));
        return $success ? $this->successResponse($accessToken) : $this->failResponse("login failed");
    }
}
