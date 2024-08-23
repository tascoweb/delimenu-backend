<?php

namespace Tests\Unit\Request;

use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UserRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_request_validation_passes()
    {

        $userData = [
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $userValidator = Validator::make($userData, (new UserRequest())->rules());
        $this->assertTrue($userValidator->passes());
    }

    public function test_user_request_validation_fails()
    {

        $userData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different_password',
        ];

        $userValidator = Validator::make($userData, (new UserRequest())->rules());
        $this->assertFalse($userValidator->passes());
    }
}
