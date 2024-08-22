<?php

namespace Tests\Unit\Resource\Auth;

use App\Http\Resources\Auth\RegistrationResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use Mockery;
use Tests\TestCase;

class RegistrationResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_resource_transforms_data()
    {
        $company = Mockery::mock(Company::class);
        $user = Mockery::mock(User::class);

        $company->shouldReceive('toArray')->andReturn([
            'id' => 1,
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'logo' => null,
            'cnpj' => '12345678000195',
            'url' => 'https://testcompany.com',
            'plan_id' => 1,
            'active' => 'Y',
            'subscription' => now(),
            'expires_at' => now()->addYear(),
            'subscription_id' => null,
            'subscription_status' => 'active',
        ]);

        $user->shouldReceive('toArray')->andReturn([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@user.com',
            'email_verified_at' => null,
        ]);

        $resource = new RegistrationResource([
            'company' => $company,
            'user' => $user,
        ]);

        $this->assertEquals([
            'company' => new CompanyResource($company),
            'user' => new UserResource($user),
        ], $resource->toArray(new Request()));
    }
}
