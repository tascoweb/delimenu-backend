<?php

namespace Tests\Unit\Service;

use App\Models\Company;
use App\Models\Tenant;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\UserService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;
    protected UserService $userService;
    protected MockInterface $userRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_create_user_successful()
    {
        $tenant = Tenant::factory()->create();


        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ];

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'tenant_id' => $tenant->id,
            'password' => Hash::make($data['password']),
        ]);


        $this->userRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($data, $tenant)
            ->andReturn($user);

        $createdUser = $this->userService->createUser($data, $tenant);


        $this->assertEquals($user, $createdUser);
        $this->assertEquals($data['name'], $createdUser->name);
        $this->assertEquals($data['email'], $createdUser->email);
        $this->assertTrue(Hash::check($data['password'], $createdUser->password));
    }

    public function test_create_user_with_invalid_data()
    {
        $this->expectException(QueryException::class);

        $tenant = Tenant::factory()->create();
        $data = [
            'name' => 'John Doe',
            'email' => 'invalid-email-format',
            'password' => 'password123',
            'role' => 'admin',
        ];

        $this->userRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($data, $tenant)
            ->andThrow(new QueryException('default', '', [], new \Exception('Invalid data')
            ));

        $this->userService->createUser($data, $tenant);
    }

    public function test_create_user_with_existing_email()
    {
        $this->expectException(QueryException::class);

        $tenant = Tenant::factory()->create();
        $existingUser = User::factory()->create(['email' => 'johndoe@example.com']);

        $data = [
            'name' => 'Jane Doe',
            'email' => $existingUser->email,
            'password' => 'password123',
            'role' => 'user',
        ];

        $this->userRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($data, $tenant)
            ->andThrow(new QueryException('default', '', [], new \Exception('Invalid data')
            ));

        $this->userService->createUser($data, $tenant);
    }


}
