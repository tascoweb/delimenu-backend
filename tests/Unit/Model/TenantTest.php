<?php

namespace Tests\Unit\Model;

use App\Models\Company;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_tenant_has_a_company_test(): void
    {
        $tenant = Tenant::factory()->create();

        $company = Company::factory()->create(['tenant_id' => $tenant->id]);

        $this->assertEquals($tenant->id, $company->tenant_id);
        $this->assertTrue($tenant->company()->exists());
    }

    public function test_a_tenant_has_many_users(): void
    {
        $tenant = Tenant::factory()->create();

        User::factory()->count(3)->create(['tenant_id' => $tenant->id]);

        $this->assertCount(3, $tenant->users);
    }

    public function test_a_tenant_has_fillable_attributes(): void
    {
        $fillable = (new Tenant)->getFillable();

        $this->assertEquals(['name', 'domain', 'database'], $fillable);
    }
}
