<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->loginService->authenticate($request->only('email', 'password'));
        if ($result['token']) {
            return response()->json(['data' =>
                ['token' => $result['token'], 'token_type' => 'Bearer'],
                'user' => new UserResource($result['user']),
                'companies' => CompanyResource::collection($result['user']->companies)
            ], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
