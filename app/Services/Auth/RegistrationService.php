<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Services\Contracts\Auth\RegistrationServiceInterface;
use App\Services\Contracts\TenantCreationServiceInterface;

class RegistrationService implements RegistrationServiceInterface
{
    protected TenantCreationServiceInterface $tenantCreationService;

    public function __construct(TenantCreationServiceInterface $tenantCreationService)
    {
        $this->tenantCreationService = $tenantCreationService;
    }

    public function register(array $tenantData, array $companyData, array $userData): array
    {
        return $this->tenantCreationService->createTenantAndCompany($tenantData, $companyData, $userData);
    }
}
