<?php

namespace Tests\Unit\Request\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_request_validation_passes()
    {

        $userData = [
            'email' => 'admin@test.com',
            'password' => 'password',
        ];

        $userValidator = Validator::make($userData, (new LoginRequest())->rules());
        $this->assertTrue($userValidator->passes());
    }

    public function test_login_request_validation_fails()
    {

        $userData = [
            'email' => 'invalid-email',
            'password' => 'short',
        ];

        $userValidator = Validator::make($userData, (new LoginRequest())->rules());
        $this->assertFalse($userValidator->passes());
    }
}
