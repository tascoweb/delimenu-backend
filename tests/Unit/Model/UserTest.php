<?php

namespace Tests\Unit\Model;

use App\Models\Company;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_check_if_user_is_admin()
    {
        Role::create(['name' => 'admin']); // Garantir que a role existe

        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->assertTrue($user->isAdmin());
    }

    public function test_it_can_check_if_user_is_not_admin()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isAdmin());
    }

    public function test_it_can_check_if_user_is_super_admin()
    {
        Role::create(['name' => 'super-admin']); // Garantir que a role existe

        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $this->assertTrue($user->isSuperAdmin());
    }

    public function test_it_can_check_if_user_is_not_super_admin()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isSuperAdmin());
    }

    public function test_it_belongs_to_a_tenant()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Tenant::class, $user->tenant);
    }

}
