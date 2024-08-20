<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class FeatureService
{
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
     * @param User $user
     * @param string $featureName
     * @return bool
     */

    public function planHasFeature(User $user, string $featureName): bool
    {
        $plan = $user->company->plan;

        if($plan){
            return $plan->features()->where('name', $featureName)->exists();
        }
        return false;
    }

    /**
     * Check if the user has access to a feature, either by feature flag or by the plan.
     *
     * @param User $user
     * @param string $featureName
     * @return bool
     */

    public function hasFeature(User $user, string $featureName): bool
    {
        return $this->userHasFeature($user, $featureName) || $this->planHasFeature($user, $featureName);
    }

}
