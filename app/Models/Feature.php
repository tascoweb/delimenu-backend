<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active', 'description','feat_can'];

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'plan_feature');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_feature');
    }
}
