<?php

namespace App\Repositories\Contracts;

use App\Models\Tenant;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data, Tenant $tenant): User;
}
