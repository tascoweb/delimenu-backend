<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\Auth\LoginServiceInterface;
use Illuminate\Support\Facades\Hash;

class LoginService implements LoginServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(array $credentials): ?array
    {

        $user = $this->userRepository->findByEmail($credentials['email']);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('API Token')->plainTextToken;
            return [
                'user' => $user,
                'token' => $token,
            ];
        }

        return null;
    }
}
