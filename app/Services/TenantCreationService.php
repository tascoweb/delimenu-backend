<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\TenantCreationServiceInterface;
use Illuminate\Support\Facades\DB;

class TenantCreationService implements TenantCreationServiceInterface
{
    protected TenantRepositoryInterface $tenantRepository;
    protected CompanyRepositoryInterface $companyRepository;
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        TenantRepositoryInterface $tenantRepository,
        CompanyRepositoryInterface $companyRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->tenantRepository = $tenantRepository;
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
    }

    public function createTenantAndCompany(array $tenantData, array $companyData, array $userData): array
    {
        return DB::transaction(function () use ($tenantData, $companyData, $userData) {
            $tenant = $this->tenantRepository->create($tenantData);
            $company = $this->companyRepository->create($companyData, $tenant);

            if (!isset($userData['role'])) {
                $userData['role'] = 'admin';
            }

            $user = $this->userRepository->create($userData, $tenant);
            $user->companies()->attach($company->id);

            return [
                'tenant' => $tenant,
                'company' => $company,
                'user' => $user,
            ];
        });
    }

}
