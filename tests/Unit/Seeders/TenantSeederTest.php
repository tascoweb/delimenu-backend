<?php

namespace Tests\Unit\Seeders;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TenantSeederTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_seeds_tenants(): void
    {
        Artisan::call('db:seed', ['--class' => 'TenantSeeder']);

        $this->assertCount(5, Tenant::all());
    }
}
