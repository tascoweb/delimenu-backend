<?php

namespace App\Services\Contracts;

use App\Models\Company;
use App\Models\Tenant;

interface CompanyServiceInterface
{
    public function createCompany(array $data, Tenant $tenant): Company;
}
