<?php

namespace App\Services\Contracts\Auth;

interface LoginServiceInterface
{
    public function authenticate(array $credentials): ?array;
}
