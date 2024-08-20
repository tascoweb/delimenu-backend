<?php

namespace Tests\Unit\Factories;

use App\Models\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureFactoryTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_creates_a_feature_with_default_values()
    {
        $feature = Feature::factory()->create();

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertNotEmpty($feature->name);
        $this->assertNotNull($feature->is_active);
    }


    public function test_it_can_create_an_inactive_feature()
    {
        $feature = Feature::factory()->inactive()->create();

        $this->assertFalse($feature->is_active);
    }
}
