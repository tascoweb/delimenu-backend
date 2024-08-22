<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'company' => new CompanyResource($this->resource['company']),
            'user' => new UserResource($this->resource['user']),
        ];
    }
}
