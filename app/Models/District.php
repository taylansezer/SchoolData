<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\ScopeType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'province_id',
        'name',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function schools(): HasMany
    {
        return $this->hasMany(School::class);
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $query) use ($user) {
            foreach ($user->roles as $role) {
                $scopeType = $role->pivot->scope_type;
                $scopeId = (int) $role->pivot->scope_id;

                if ($scopeType === ScopeType::DISTRICT) {
                    $query->orWhere('id', $scopeId);
                }

                if ($scopeType === ScopeType::PROVINCE) {
                    $query->orWhere('province_id', $scopeId);
                }
            }
        });
    }
}
