<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company' => ['required', 'array'],
            'user' => ['required', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'company.*' => 'Company data is invalid.',
            'user.*' => 'User data is invalid.',
        ];
    }

    public function getCompanyData(): array
    {
        return $this->input('company');
    }

    public function getUserData(): array
    {
        return $this->input('user');
    }
}
