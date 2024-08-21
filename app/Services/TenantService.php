<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Company;
use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Services\Contracts\CompanyServiceInterface;

class TenantService implements Contracts\TenantServiceInterface
{
    protected TenantRepositoryInterface $tenantRepository;

    public function __construct(TenantRepositoryInterface $tenantRepository)
    {
        $this->tenantRepository = $tenantRepository;
    }

    public function createTenant(array $data): Tenant
    {
        return $this->tenantRepository->create($data);
    }
}
