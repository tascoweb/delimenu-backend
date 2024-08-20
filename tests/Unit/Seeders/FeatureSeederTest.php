<?php

namespace Tests\Unit\Seeders;

use App\Models\Feature;
use Database\Seeders\FeatureSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureSeederTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_seeds_features_into_the_database()
    {
        $this->seed(FeatureSeeder::class);

        $this->assertDatabaseCount('features', 10);
        $this->assertInstanceOf(Feature::class, Feature::first());
    }
}
