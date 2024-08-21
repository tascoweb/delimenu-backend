<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Feature;
use App\Repositories\Contracts\FeatureRepositoryInterface;

class FeatureRepository implements Contracts\FeatureRepositoryInterface
{

    /**
     * @param array<string, mixed> $data
     * @return Feature
     */
    public function create(array $data): Feature
    {
        return Feature::create([
            'name' => $data['name'],
            'is_active' => $data['is_active'] ?? true,
            'description' => $data['description'],
            'feat_can' => $data['feat_can']
        ]);
    }

    public function findByName(string $name): ?Feature
    {
        return Feature::where('name', $name)->first();
    }
}
