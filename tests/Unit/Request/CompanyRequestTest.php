<?php

namespace Tests\Unit\Request;

use App\Http\Requests\CompanyRequest;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CompanyRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_request_validation_passes()
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

        $companyValidator = Validator::make($companyData, (new CompanyRequest())->rules());
        $this->assertTrue($companyValidator->passes());
    }

    public function test_company_request_validation_fails()
    {
        // Dados inválidos para company e user
        $companyData = [
            'name' => '',
            'email' => 'invalid-email',
            'cnpj' => '',
            'url' => '',
            'plan_id' => null,
        ];

        $companyValidator = Validator::make($companyData, (new CompanyRequest())->rules());
        $this->assertFalse($companyValidator->passes());
    }
}
