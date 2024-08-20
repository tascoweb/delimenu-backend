<?php

namespace Tests\Unit\Factories;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantFactoryTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_creates_a_tenant_with_factory(): void
    {
        $tenant = Tenant::factory()->create();

        $this->assertDatabaseHas('tenants', [
            'name' => $tenant->name,
            'domain' => $tenant->domain,
            'database' => $tenant->database,
        ]);
    }
}
