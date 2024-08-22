<?php

namespace Tests\Unit\Controller\Auth;


use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_can_register_a_new_company_and_user()
    {
        $freePlan = Plan::firstOrCreate(
            ['name' => 'Free Plan'],
            ['url' => 'free-plan', 'price' => 0.00, 'description' => 'Plano gratuito']
        );
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

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
            'role' => 'admin',
        ];

        $response = $this->postJson('/api/register', [
            'company' => $companyData,
            'user' => $userData,
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'company' => [
                        'id', 'name', 'email', 'logo', 'cnpj', 'url', 'active', 'subscription', 'expires_at', 'subscription_id', 'subscription_status', 'plan_id'
                    ],
                    'user' => [
                        'id', 'name', 'email', 'email_verified_at'
                    ]
                ]
            ]);

        // Verificar se os dados foram criados no banco de dados
        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'email' => 'test@company.com'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Admin User',
            'email' => 'admin@test.com'
        ]);
    }
}
