<?php

namespace Tests\Unit\Request\Auth;

use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\UserRequest;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RegistrationRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_request_validation_passes()
    {
        $freePlan = Plan::firstOrCreate(
            ['name' => 'Free Plan'],
            ['url' => 'free-plan', 'price' => 0.00, 'description' => 'Plano gratuito']
        );
        // Dados válidos para company e user
        $companyData = [
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'cnpj' => '12345678000195',
            'url' => 'https://testcompany.com',
            'plan_id' => $freePlan->id,
        ];

        $userData = [
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        // Validação dos arrays separadamente
        $registrationValidator = Validator::make(
            ['company' => $companyData, 'user' => $userData],
            (new RegistrationRequest())->rules()
        );
        $companyValidator = Validator::make($companyData, (new CompanyRequest())->rules());
        $userValidator = Validator::make($userData, (new UserRequest())->rules());

        $this->assertTrue($registrationValidator->passes());
        $this->assertTrue($companyValidator->passes());
        $this->assertTrue($userValidator->passes());
    }

    public function test_registration_request_validation_fails()
    {
        // Dados inválidos para company e user
        $companyData = [
            'name' => '',
            'email' => 'invalid-email',
            'cnpj' => '',
            'url' => '',
            'plan_id' => null,
        ];

        $userData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different_password',
        ];

        // Validação dos arrays separadamente
        $companyValidator = Validator::make($companyData, (new CompanyRequest())->rules());
        $userValidator = Validator::make($userData, (new UserRequest())->rules());
        $registrationValidator = Validator::make(
            ['company' => $companyData],
            (new RegistrationRequest())->rules()
        );

        $this->assertFalse($registrationValidator->passes());
        $this->assertFalse($companyValidator->passes());
        $this->assertFalse($userValidator->passes());
    }
}
