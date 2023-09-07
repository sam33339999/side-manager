<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $service
    ) {
        $this->middleware('jwt.auth', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $req): JsonResponse
    {
        if (!empty($req->getErrors())) {
            return $this->failResponse($req->getErrors(), 400);
        }

        [$success, $accessToken] = $this->service->login(credentials: $req->only(['username', 'password']));
        return $success ? $this->successResponse(data: $accessToken) : $this->failResponse(message: "login failed");
    }

    public function register(RegisterRequest $req): JsonResponse
    {
        if (!empty($req->getErrors())) {
            return $this->failResponse($req->getErrors(), 400);
        }

        $success = $this->service->register(registerData: $req->only(['username', 'password', 'name']));
        return $success ? $this->successResponse(code: 201): $this->failResponse(code: 400);
    }

    public function me(): JsonResponse
    {
        return $this->successResponse(data: auth()->user());
    }
}
