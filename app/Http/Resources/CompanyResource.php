<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'logo' => $this->logo,
            'cnpj' => $this->cnpj,
            'url' => $this->url,
            'plan_id' => $this->plan_id,
            'active' => $this->active,
            'subscription' => $this->subscription,
            'expires_at' => $this->expires_at,
            'subscription_id' => $this->subscription_id,
            'subscription_status' => $this->subscription_status,
        ];
    }
}
