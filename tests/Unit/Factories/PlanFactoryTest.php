<?php

namespace Tests\Unit\Factories;

use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_plan_factory_creates_a_plan()
    {
        $plan = Plan::factory()->create();

        $this->assertInstanceOf(Plan::class, $plan);
        $this->assertDatabaseHas('plans', ['id' => $plan->id]);
    }

    public function test_plan_factory_creates_free_plan()
    {
        $plan = Plan::factory()->free()->create();

        $this->assertEquals(0.00, $plan->price);
        $this->assertEquals('Free Plan', $plan->name);
        $this->assertEquals('free-plan', $plan->url);
    }

    public function test_plan_factory_creates_premium_plan()
    {
        $plan = Plan::factory()->premium()->create();

        $this->assertEquals(29.90, $plan->price);
        $this->assertEquals('Premium Plan', $plan->name);
        $this->assertEquals('premium-plan', $plan->url);
    }
}
