<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Contracts\Auth\LogoutServiceInterface;

class LogoutService implements LogoutServiceInterface
{
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
