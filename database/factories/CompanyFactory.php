<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Company;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{


    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => $this->faker->company,
            'uuid' => $this->faker->uuid,
            'email' => $this->faker->companyEmail,
            'logo' => null,
            'cnpj' => $this->faker->unique()->numerify('##.###.###/####-##'),
            'url' => $this->faker->unique()->url,
            'active' => 'Y',
            'subscription' => now(),
            'expires_at' => now()->addYear(),
            'subscription_id' => $this->faker->randomNumber(),
            'subscription_status' => 'active',
            'plan_id' => Plan::factory(),
        ];
    }
}
