<?php

namespace Tests\Unit\Service;

use App\Models\Company;
use App\Models\Tenant;
use App\Models\User;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\TenantCreationService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class TenantCreationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TenantCreationService $tenantCreationService;
    protected MockInterface $tenantRepositoryMock;
    protected MockInterface $companyRepositoryMock;
    protected MockInterface $userRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenantRepositoryMock = Mockery::mock(TenantRepositoryInterface::class);
        $this->companyRepositoryMock = Mockery::mock(CompanyRepositoryInterface::class);
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);

        $this->tenantCreationService = new TenantCreationService(
            $this->tenantRepositoryMock,
            $this->companyRepositoryMock,
            $this->userRepositoryMock
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_create_tenant_company_and_user_successful()
    {
        $tenantData = [
            'name' => 'Acme Corp',
            'domain' => 'acme.com',
            'database' => 'acme_db',
        ];

        $companyData = [
            'name' => 'Acme Company',
            'email' => 'contact@acme.com',
            'cnpj' => '12.345.678/0001-99',
            'url' => 'https://acme.com',
            'plan_id' => 1,
        ];

        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ];

        $tenant = new Tenant($tenantData);
        $company = new Company(array_merge($companyData, ['tenant_id' => $tenant->id]));
        $user = new User(array_merge($userData, [
            'tenant_id' => $tenant->id,
            'company_id' => $company->id,
            'password' => Hash::make($userData['password'])
        ]));

        $this->tenantRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($tenantData)
            ->andReturn($tenant);

        $this->companyRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($companyData, $tenant)
            ->andReturn($company);

        $this->userRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($userData, $tenant)
            ->andReturn($user);

        DB::beginTransaction();

        $created = $this->tenantCreationService->createTenantAndCompany($tenantData, $companyData, $userData);

        $this->assertEquals($tenant, $created['tenant']);
        $this->assertEquals($company, $created['company']);
        $this->assertEquals($user, $created['user']);
        $this->assertEquals($tenantData['name'], $created['tenant']->name);
        $this->assertEquals($tenantData['domain'], $created['tenant']->domain);
        $this->assertEquals($tenantData['database'], $created['tenant']->database);

        DB::rollBack(); // Rollback para manter o banco de dados limpo após o teste
    }

    public function test_create_tenant_company_and_user_with_transaction_failure()
    {
        $tenantData = [
            'name' => 'Acme Corp',
            'domain' => 'acme.com',
            'database' => 'acme_db',
        ];

        $companyData = [
            'name' => 'Acme Company',
            'email' => 'contact@acme.com',
            'cnpj' => '12.345.678/0001-99',
            'url' => 'https://acme.com',
            'plan_id' => 1,
        ];

        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ];

        $tenant = new Tenant($tenantData);
        $company = new Company(array_merge($companyData, ['tenant_id' => $tenant->id]));

        $this->tenantRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($tenantData)
            ->andReturn($tenant);

        $this->companyRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($companyData, $tenant)
            ->andThrow(new QueryException(
                'default', '', [], new Exception('Failed to create company')
            ));

        $this->expectException(QueryException::class);

        $this->tenantCreationService->createTenantAndCompany($tenantData, $companyData, $userData);
    }
}
