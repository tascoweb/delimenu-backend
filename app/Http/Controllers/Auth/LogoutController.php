<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\LogoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    protected LogoutService $logoutService;

    public function __construct(LogoutService $logoutService)
    {
        $this->logoutService = $logoutService;
    }

    public function logout(Request $request): JsonResponse
    {
        $this->logoutService->logout($request->user());
        return response()->json(['data' =>['message' => 'Logged out successfully']], 200);
    }
}
