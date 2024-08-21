<?php

namespace Tests\Unit\Service;

use App\Models\Company;
use App\Models\Tenant;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Services\CompanyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class CompanyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CompanyRepositoryInterface|(MockInterface&LegacyMockInterface) $companyRepositoryMock;
    protected CompanyService $companyService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->companyRepositoryMock = Mockery::mock(CompanyRepositoryInterface::class);
        $this->companyService = new CompanyService($this->companyRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_can_create_a_company()
    {

        $tenant = Tenant::factory()->create();
        $companyData = [
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'cnpj' => '12345678901234',
            'url' => 'http://company.com',
            'plan_id' => 1,
        ];

        $company = new Company($companyData);
        $company->tenant_id = $tenant->id;
        $company->uuid = (string) \Illuminate\Support\Str::uuid();
        $company->active = 'Y';
        $company->subscription_status = 'active';
        $company->subscription = now();
        $company->expires_at = now()->addYear();

        $this->companyRepositoryMock
            ->shouldReceive('create')
            ->with($companyData, $tenant)
            ->andReturn($company);

        $createdCompany = $this->companyService->createCompany($companyData, $tenant);

        $this->assertInstanceOf(Company::class, $createdCompany);
        $this->assertEquals($company->name, $createdCompany->name);
        $this->assertEquals($company->email, $createdCompany->email);
        $this->assertEquals($company->cnpj, $createdCompany->cnpj);
        $this->assertEquals($company->url, $createdCompany->url);
        $this->assertEquals($company->tenant_id, $createdCompany->tenant_id);
        $this->assertEquals($company->uuid, $createdCompany->uuid);
        $this->assertEquals($company->active, $createdCompany->active);
        $this->assertEquals($company->subscription_status, $createdCompany->subscription_status);
        $this->assertEquals($company->subscription, $createdCompany->subscription);
        $this->assertEquals($company->expires_at, $createdCompany->expires_at);
    }


}
