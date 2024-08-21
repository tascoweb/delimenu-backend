<?php

namespace Tests\Unit\Service;

use App\Models\Company;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\User;
use App\Repositories\Contracts\FeatureRepositoryInterface;
use App\Services\FeatureService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class FeatureServiceTest extends TestCase
{
    use RefreshDatabase;

    protected (MockInterface&LegacyMockInterface)|FeatureRepositoryInterface $featureRepositoryMock;
    protected FeatureService $featureService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->featureRepositoryMock = Mockery::mock(FeatureRepositoryInterface::class);
        $this->featureService = new FeatureService($this->featureRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }


    public function test_it_can_check_if_user_has_feature()
    {
        $feature = Feature::factory()->create();
        $user = User::factory()->create();
        $user->features()->attach($feature);

        $this->featureRepositoryMock
            ->shouldReceive('findByName')
            ->with($feature->name)
            ->andReturn($feature);

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

        $this->featureRepositoryMock
            ->shouldReceive('findByName')
            ->with($feature->name)
            ->andReturn($feature);

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

        $this->featureRepositoryMock
            ->shouldReceive('findByName')
            ->with($feature->name)
            ->andReturn($feature);

        // User has feature directly
        $this->assertTrue($this->featureService->hasFeature($user, $feature->name));

        // User has feature through the plan
        $user->features()->detach($feature);
        $this->assertTrue($this->featureService->hasFeature($user, $feature->name));

        // User does not have feature
        $this->featureRepositoryMock
            ->shouldReceive('findByName')
            ->with('Nonexistent Feature')
            ->andReturn(null);

        $this->assertFalse($this->featureService->hasFeature($user, 'Nonexistent Feature'));
    }

    public function test_it_can_create_a_feature()
    {
        $data = [
            'name' => 'New Feature',
            'description' => 'Feature Description',
            'feat_can' => 'some_value',
            'is_active' => true,
        ];

        $feature = new Feature($data);

        $this->featureRepositoryMock
            ->shouldReceive('create')
            ->with($data)
            ->andReturn($feature);

        $this->assertEquals($feature, $this->featureService->createFeature($data));
    }

    public function test_it_can_add_feature_to_user()
    {
        $feature = Feature::factory()->create();
        $user = User::factory()->create();

        $this->featureRepositoryMock
            ->shouldReceive('findByName')
            ->with($feature->name)
            ->andReturn($feature);

        $user->features()->attach($feature);

        $this->assertTrue($this->featureService->addFeatureToUser($user, $feature->name));

        $this->featureRepositoryMock
            ->shouldReceive('findByName')
            ->with('Nonexistent Feature')
            ->andReturn(null);
        $this->assertFalse($this->featureService->addFeatureToUser($user, 'Nonexistent Feature'));
        $this->assertFalse($user->features()->where('name', 'Nonexistent Feature')->exists());
    }

    public function test_it_can_add_feature_to_plan()
    {
        $feature = Feature::factory()->create();
        $plan = Plan::factory()->create();

        $this->featureRepositoryMock
            ->shouldReceive('findByName')
            ->with($feature->name)
            ->andReturn($feature);

        $plan->features()->attach($feature);

        $this->assertTrue($this->featureService->addFeatureToPlan($plan, $feature->name));

        $this->featureRepositoryMock
            ->shouldReceive('findByName')
            ->with('Nonexistent Feature')
            ->andReturn(null);
        $this->assertFalse($this->featureService->addFeatureToPlan($plan, 'Nonexistent Feature'));
        $this->assertFalse($plan->features()->where('name', 'Nonexistent Feature')->exists());
    }

    public function test_it_can_get_feature_details()
    {
        $feature = Feature::factory()->create();

        $this->featureRepositoryMock
            ->shouldReceive('findByName')
            ->with($feature->name)
            ->andReturn($feature);

        $this->assertEquals($feature, $this->featureService->getFeatureDetails($feature->name));

        $this->featureRepositoryMock
            ->shouldReceive('findByName')
            ->with('Nonexistent Feature')
            ->andReturn(null);

        $this->assertNull($this->featureService->getFeatureDetails('Nonexistent Feature'));
    }


}
