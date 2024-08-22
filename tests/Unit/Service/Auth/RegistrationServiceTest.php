<?php

namespace Tests\Unit\Service\Auth;

use App\Models\Company;
use App\Models\Tenant;
use App\Models\User;
use App\Services\Auth\RegistrationService;
use App\Services\Contracts\TenantCreationServiceInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected RegistrationService $registrationService;
    protected Mockery\MockInterface $tenantCreationServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenantCreationServiceMock = Mockery::mock(TenantCreationServiceInterface::class);
        $this->registrationService = new RegistrationService($this->tenantCreationServiceMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_register_calls_create_tenant_and_company()
    {
        $tenantData = ['name' => 'Test Tenant', 'domain' => 'test.com', 'database' => 'test_db'];
        $companyData = ['name' => 'Test Company', 'email' => 'test@company.com', 'cnpj' => '12345678000195', 'url' => 'https://testcompany.com', 'plan_id' => 1];
        $userData = ['name' => 'Admin User', 'email' => 'admin@test.com', 'password' => 'password', 'role' => 'admin'];

        $createdTenant = Mockery::mock(Tenant::class);
        $createdCompany = Mockery::mock(Company::class);
        $createdUser = Mockery::mock(User::class);

        $this->tenantCreationServiceMock
            ->shouldReceive('createTenantAndCompany')
            ->once()
            ->with($tenantData, $companyData, $userData)
            ->andReturn([
                'tenant' => $createdTenant,
                'company' => $createdCompany,
                'user' => $createdUser,
            ]);

        $result = $this->registrationService->register($tenantData, $companyData, $userData);

        $this->assertEquals($createdTenant, $result['tenant']);
        $this->assertEquals($createdCompany, $result['company']);
        $this->assertEquals($createdUser, $result['user']);
    }
}
