<?php

namespace Tests\Unit\Factories;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_factory_creates_a_company()
    {
        $company = Company::factory()->create();

        $this->assertInstanceOf(Company::class, $company);
        $this->assertDatabaseHas('companies', ['id' => $company->id]);
    }

    public function test_company_factory_creates_with_relations()
    {
        $company = Company::factory()->create();

        $this->assertNotNull($company->tenant);
        $this->assertNotNull($company->plan);
    }
}
