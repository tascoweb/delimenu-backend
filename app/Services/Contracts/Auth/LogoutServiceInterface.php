<?php

namespace App\Services\Contracts\Auth;

use App\Models\User;

interface LogoutServiceInterface
{
    public function logout(User $user): void;
}
