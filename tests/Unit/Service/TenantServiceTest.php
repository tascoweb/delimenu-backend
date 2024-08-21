<?php

namespace Tests\Unit\Service;

use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Services\TenantService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class TenantServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TenantService $tenantService;
    protected MockInterface $tenantRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenantRepositoryMock = Mockery::mock(TenantRepositoryInterface::class);
        $this->tenantService = new TenantService($this->tenantRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_create_tenant_successful()
    {
        $data = [
            'name' => 'Acme Corp',
            'domain' => 'acme.com',
            'database' => 'acme_db',
        ];

        $tenant = new Tenant([
            'name' => $data['name'],
            'domain' => $data['domain'],
            'database' => $data['database'],
        ]);

        $this->tenantRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($tenant);

        $createdTenant = $this->tenantService->createTenant($data);

        $this->assertEquals($tenant, $createdTenant);
        $this->assertEquals($data['name'], $createdTenant->name);
        $this->assertEquals($data['domain'], $createdTenant->domain);
        $this->assertEquals($data['database'], $createdTenant->database);
    }

    public function test_create_tenant_with_invalid_data()
    {
        $this->expectException(QueryException::class);

        $data = [
            'name' => 'Invalid Tenant',
            'domain' => 'invalid-domain', // Supondo que o domínio é inválido
            'database' => 'invalid_db',
        ];

        $this->tenantRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andThrow(new QueryException(
                'default', '', [], new Exception('Invalid domain or database')
            ));

        $this->tenantService->createTenant($data);
    }
}
