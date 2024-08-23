<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Company;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\User;
use App\Repositories\Contracts\FeatureRepositoryInterface;
use App\Services\Contracts\FeatureServiceInterface;

class FeatureService implements FeatureServiceInterface
{

    protected FeatureRepositoryInterface $featureRepository;

    public function __construct(FeatureRepositoryInterface $featureRepository)
    {
        $this->featureRepository = $featureRepository;
    }

    /**
     * Check if the user has a specific feature flag enabled.
     *
     * @param User $user
     * @param string $featureName
     * @return bool
     */

    public function userHasFeature(User $user, string $featureName): bool
    {
        return $user->features()->where('name', $featureName)->exists();
    }

    /**
     * Check if the feature is available in the user's company plan.
     *
     * @param Company $company
     * @param string $featureName
     * @return bool
     */

    public function planHasFeature(Company $company, string $featureName, ): bool
    {
        $plan = $company->plan;

        if($plan){
            return $plan->features()->where('name', $featureName)->exists();
        }
        return false;
    }

    /**
     * Check if the user has access to a feature, either by feature flag or by the plan.
     *
     * @param User $user
     * @param Company $company
     * @param string $featureName
     * @return bool
     */

    public function hasFeature(User $user, Company $company, string $featureName): bool
    {
        /* check if user belongs to company*/
        if(!$company->users()->where('users.id', $user->id)->exists()){
            return false;
        }
        return $this->userHasFeature($user, $featureName) || $this->planHasFeature($company, $featureName);
    }

    /**
     * @param array<string, mixed> $data
     * @return Feature
     */
    public function createFeature(array $data): Feature
    {
        return $this->featureRepository->create($data);
    }

    public function addFeatureToUser(User $user, string $featureName): bool
    {
        $feature = $this->featureRepository->findByName($featureName);

        if (!$feature) {
            return false;
        }

        $user->features()->attach($feature->id);
        return true;
    }

    public function addFeatureToPlan(Plan $plan, string $featureName): bool
    {
        $feature = $this->featureRepository->findByName($featureName);

        if (!$feature) {
            return false;
        }

        $plan->features()->attach($feature->id);
        return true;
    }

    public function getFeatureDetails(string $featureName): ?Feature
    {
        return $this->featureRepository->findByName($featureName);
    }

}
