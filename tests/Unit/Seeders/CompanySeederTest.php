<?php

namespace Tests\Unit\Seeders;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CompanySeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_seeder_seeds_companies_correctly()
    {
        // Run the seeder
        Artisan::call('db:seed', ['--class' => 'CompanySeeder']);

        // Assert that the seeder created 3 companies
        $this->assertCount(3, Company::all());
    }
}
