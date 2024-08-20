<?php

namespace Tests\Unit\Model;

use App\Models\Feature;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_feature()
    {
        $feature = Feature::factory()->create([
            'name' => 'Test Feature',
            'is_active' => true,
            'description' => 'This is a test feature',
            'feat_can' => 'some_capability',
        ]);

        $this->assertDatabaseHas('features', [
            'name' => 'Test Feature',
            'is_active' => true,
            'description' => 'This is a test feature',
            'feat_can' => 'some_capability',
        ]);

        $this->assertInstanceOf(Feature::class, $feature);
    }


    public function test_it_can_belong_to_many_plans()
    {
        $feature = Feature::factory()->create();
        $plan = Plan::factory()->create();

        $feature->plans()->attach($plan);

        $this->assertTrue($feature->plans->contains($plan));
    }

    public function test_it_can_belong_to_many_users()
    {
        $feature = Feature::factory()->create();
        $user = User::factory()->create();

        $feature->users()->attach($user);

        $this->assertTrue($feature->users->contains($user));
    }
}
