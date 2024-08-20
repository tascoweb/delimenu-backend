<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Plan>
 */
class PlanFactory extends Factory
{

    protected $model = Plan::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'url' => $this->faker->unique()->url(),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'description' => $this->faker->sentence(),
        ];
    }

    public function free(): PlanFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => 0.00,
                'name' => 'Free Plan',
                'url' => 'free-plan',
            ];
        });
    }

    public function premium(): PlanFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => 29.90,
                'name' => 'Premium Plan',
                'url' => 'premium-plan',
            ];
        });
    }
}
