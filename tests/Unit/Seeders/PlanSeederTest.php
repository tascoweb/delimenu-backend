<?php

namespace Tests\Unit\Seeders;

use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PlanSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_plan_seeder_seeds_plans_correctly()
    {
        // Run the seeder
        Artisan::call('db:seed', ['--class' => 'PlanSeeder']);

        // Assert that the seeder created the Free Plan and Premium Plan
        $this->assertDatabaseHas('plans', ['name' => 'Free Plan']);
        $this->assertDatabaseHas('plans', ['name' => 'Premium Plan']);
    }

    public function test_plan_seeder_does_not_duplicate_plans()
    {
        // Run the seeder twice
        Artisan::call('db:seed', ['--class' => 'PlanSeeder']);
        Artisan::call('db:seed', ['--class' => 'PlanSeeder']);

        // Assert that there are only one Free Plan and one Premium Plan
        $this->assertCount(1, Plan::where('name', 'Free Plan')->get());
        $this->assertCount(1, Plan::where('name', 'Premium Plan')->get());
    }
}
