<?php

namespace App\Services\Contracts\Auth;

interface RegistrationServiceInterface
{
    public function register(array $tenantData, array $companyData, array $userData): array;
}
