<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\Models\Concerns\ImplementsTenant;


class Tenant extends Model implements IsTenant
{
    use HasFactory;
    use ImplementsTenant;

    protected $fillable = ['name', 'domain', 'database'];

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'tenant_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'tenant_id');
    }

    public function currentPlan(): Plan
    {
        return $this->plans->first();
    }
}
