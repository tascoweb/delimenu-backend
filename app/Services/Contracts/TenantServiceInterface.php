<?php

namespace App\Services\Contracts;

use App\Models\Tenant;

interface TenantServiceInterface
{
    public function createTenant(array $data): Tenant;
}
