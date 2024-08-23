<?php

namespace Tests\Unit\Factories;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_user()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function test_it_has_required_attributes()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john.doe@example.com', $user->email);
        $this->assertNotNull($user->password);
        $this->assertNotNull($user->tenant_id);
    }

    public function test_it_casts_email_verified_at_to_datetime()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->assertInstanceOf(Carbon::class, $user->email_verified_at);
    }
}
