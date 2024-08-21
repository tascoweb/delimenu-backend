<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;

class TenantRepository implements Contracts\TenantRepositoryInterface
{

    /**
     * @param array<string, mixed> $data
     * @return Tenant
     */
    public function create(array $data): Tenant
    {
        return Tenant::create([
            'name' => $data['name'],
            'domain' => $data['domain'],
            'database' => $data['database'],
        ]);
    }
}
