<?php

namespace App\Services\Contracts;

use App\Models\Company;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\User;

interface FeatureServiceInterface
{
    public function userHasFeature(User $user, string $featureName): bool;

    public function planHasFeature(Company $company, string $featureName): bool;

    public function hasFeature(User $user,Company $company, string $featureName): bool;

    public function createFeature(array $data): Feature;

    public function addFeatureToUser(User $user, string $featureName): bool;

    public function addFeatureToPlan(Plan $plan, string $featureName): bool;

    public function getFeatureDetails(string $featureName): ?Feature;

}
