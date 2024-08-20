<?php

namespace Tests\Unit\Model;

use App\Models\Company;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_belongs_to_tenant()
    {
        $company = Company::factory()->create();

        $this->assertInstanceOf(Tenant::class, $company->tenant);
    }

    public function test_company_belongs_to_plan()
    {
        $company = Company::factory()->create();

        $this->assertInstanceOf(Plan::class, $company->plan);
    }

    public function test_company_has_many_users()
    {
        $company = Company::factory()->create();
        User::factory()->count(3)->create(['company_id' => $company->id]);

        $this->assertCount(3, $company->users);
    }

    public function test_company_can_be_created()
    {
        $company = Company::factory()->create([
            'name' => 'Test Company',
            'uuid' => '12345-67890',
            'email' => 'test@company.com',
            'cnpj' => '12.345.678/0001-99',
        ]);

        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'uuid' => '12345-67890',
            'email' => 'test@company.com',
            'cnpj' => '12.345.678/0001-99',
        ]);
    }
}
