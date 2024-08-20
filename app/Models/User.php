<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Tenant;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Feature;

/**
 * @property int $tenant_id
 * @property Tenant $tenant
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* relation with tenants */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    /* relation with companies */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }


    /* check admin */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /* check super admin */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    /* relation with features */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'user_feature');
    }
}
