<?php

namespace App\Repositories\Contracts;

use App\Models\Company;
use App\Models\Tenant;

interface CompanyRepositoryInterface
{
    public function create(array $data, Tenant $tenant): Company;
}
