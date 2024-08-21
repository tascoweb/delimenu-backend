<?php

namespace App\Repositories\Contracts;

use App\Models\Feature;

interface FeatureRepositoryInterface
{
    public function create(array $data): Feature;

    public function findByName(string $name): ?Feature;
}
