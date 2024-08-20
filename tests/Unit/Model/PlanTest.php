<?php

namespace Tests\Unit\Model;

use App\Models\Company;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_plan_has_many_features()
    {
        $plan = Plan::factory()->create();
        $feature = Feature::factory()->create();

        $plan->features()->attach($feature);

        $this->assertTrue($plan->features->contains($feature));
    }

    public function test_plan_has_many_companies()
    {
        $plan = Plan::factory()->create();
        $company = Company::factory()->create();

        $plan->companies()->save($company);

        $this->assertTrue($plan->companies->contains($company));
    }

    public function test_plan_can_be_created()
    {
        $plan = Plan::factory()->create([
            'name' => 'Basic Plan',
            'url' => 'basic-plan',
            'price' => 9.99,
            'description' => 'Plano básico para testes.',
        ]);

        $this->assertDatabaseHas('plans', [
            'name' => 'Basic Plan',
            'url' => 'basic-plan',
            'price' => 9.99,
            'description' => 'Plano básico para testes.',
        ]);
    }
}
