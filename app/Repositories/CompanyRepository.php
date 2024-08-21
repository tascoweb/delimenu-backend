<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Company;
use App\Models\Tenant;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Support\Str;

class CompanyRepository implements Contracts\CompanyRepositoryInterface
{

    /**
     * @param array<string, mixed> $data
     * @param Tenant $tenant
     * @return Company
     */
    public function create(array $data, Tenant $tenant): Company
    {
        return Company::create([
            'tenant_id' => $tenant->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'cnpj' => $data['cnpj'],
            'url' => $data['url'],
            'uuid' => (string) Str::uuid(),
            'plan_id' => $data['plan_id'],
            'active' => 'Y',
            'subscription_status' => 'active',
            'subscription' => now(),
            'expires_at' => now()->addYear(),
        ]);
    }
}
