<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'price', 'description'];

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'plan_feature');
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }




}
