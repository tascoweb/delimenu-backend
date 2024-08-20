<?php

namespace Tests\Unit\Seeders;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_users_correctly()
    {
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);

        $this->assertCount(3, User::all()); // Ajuste conforme necessário
    }
}
