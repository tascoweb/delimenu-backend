<?php

namespace Tests\Unit\Service;

use App\Models\Company;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\User;
use App\Services\FeatureService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureServiceTest extends TestCase
{
    use RefreshDatabase;

    protected FeatureService $featureService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->featureService = new FeatureService();
    }


    public function test_it_can_check_if_user_has_feature()
    {
        $feature = Feature::factory()->create();
        $user = User::factory()->create();
        $user->features()->attach($feature);

        $this->assertTrue($this->featureService->userHasFeature($user, $feature->name));
        $this->assertFalse($this->featureService->userHasFeature($user, 'Nonexistent Feature'));
    }


    public function test_it_can_check_if_plan_has_feature()
    {
        $feature = Feature::factory()->create();
        $plan = Plan::factory()->create();
        $plan->features()->attach($feature);

        $company = Company::factory()->create(['plan_id' => $plan->id]);
        $user = User::factory()->create(['company_id' => $company->id]);

        $this->assertTrue($this->featureService->planHasFeature($user, $feature->name));
        $this->assertFalse($this->featureService->planHasFeature($user, 'Nonexistent Feature'));
    }


    public function test_it_can_check_if_user_has_access_to_feature()
    {
        $feature = Feature::factory()->create();
        $plan = Plan::factory()->create();
        $plan->features()->attach($feature);

        $company = Company::factory()->create(['plan_id' => $plan->id]);
        $user = User::factory()->create(['company_id' => $company->id]);
        $user->features()->attach($feature);

        // User has feature directly
        $this->assertTrue($this->featureService->hasFeature($user, $feature->name));

        // User has feature through the plan
        $user->features()->detach($feature);
        $this->assertTrue($this->featureService->hasFeature($user, $feature->name));

        // User does not have feature
        $this->assertFalse($this->featureService->hasFeature($user, 'Nonexistent Feature'));
    }
}
