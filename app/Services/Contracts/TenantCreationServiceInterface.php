<?php

namespace App\Services\Contracts;

use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

interface TenantCreationServiceInterface
{
    public function __construct(
        TenantRepositoryInterface $tenantRepository,
        CompanyRepositoryInterface $companyRepository,
        UserRepositoryInterface $userRepository
    );
    public function createTenantAndCompany(array $tenantData, array $companyData, array $userData): array;

}
