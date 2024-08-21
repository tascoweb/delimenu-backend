<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Company;
use App\Models\Plan;
use App\Models\Tenant;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Services\Contracts\CompanyServiceInterface;
use Illuminate\Support\Str;

class CompanyService implements Contracts\CompanyServiceInterface
{
    protected CompanyRepositoryInterface $companyRepository;

    /**
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param array<string, mixed> $data
     * @param Tenant $tenant
     * @return Company
     */
    public function createCompany(array $data, Tenant $tenant): Company
    {
        return $this->companyRepository->create($data, $tenant);
    }
}
