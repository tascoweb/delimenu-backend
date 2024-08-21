<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tenant;

class Company extends Model
{
    use HasFactory;

    /**
     * @var \Illuminate\Support\HigherOrderCollectionProxy|mixed
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'plan_id',
        'uuid',
        'email',
        'logo',
        'cnpj',
        'url',
        'active',
        'subscription',
        'expires_at',
        'subscription_id',
        'subscription_status',
    ];

    /* relation with users */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /* relation with tenant */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
