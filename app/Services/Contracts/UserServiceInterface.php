<?php

namespace App\Services\Contracts;

use App\Models\Tenant;
use App\Models\User;

interface UserServiceInterface
{

    public function createUser(array $data, Tenant $tenant): User;
}
