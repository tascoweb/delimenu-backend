<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Auth\RegistrationResource;
use App\Services\Contracts\Auth\RegistrationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    protected RegistrationServiceInterface $registrationService;

    public function __construct(RegistrationServiceInterface $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function register(RegistrationRequest $request): JsonResponse
    {
        $validatedCompany = Validator::make($request->getCompanyData(), (new CompanyRequest())->rules());
        $validatedUser = Validator::make($request->getUserData(), (new UserRequest())->rules());

        if ($validatedCompany->fails() || $validatedUser->fails()) {
            return response()->json(['error' =>[
                'message' => 'The given data was invalid.',
                'errors' => array_merge($validatedCompany->errors()->toArray(), $validatedUser->errors()->toArray()),
            ]], 422);
        }

        $companyData = $validatedCompany->validated();
        $userData = $validatedUser->validated();
        $suffix = Str::random(8);
        $tenantData = [
            'name' => $companyData['name'],
            'domain' => Str::slug($companyData['name']) . '_' . $suffix,
            'database' => Str::slug($companyData['name']) . '_' . $suffix,
        ];

        $created = $this->registrationService->register($tenantData, $companyData, $userData);

        return response()->json(['data' =>new RegistrationResource($created)], 201);
    }
}
