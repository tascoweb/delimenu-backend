<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tenant;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements Contracts\UserRepositoryInterface
{

    /**
     * @param array<string, mixed> $data
     * @param Tenant $tenant
     * @return User
     */
    public function create(array $data, Tenant $tenant): User
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tenant_id' => $tenant->id,
        ]);

        $user->assignRole($data['role']);

        return $user;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
