<?php

namespace App\Models;

use App\Enums\ScopeType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'province_id',
        'name',
    ];

    /**
     * @return BelongsTo<Province,  $this>
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * @return HasMany<School, $this>
     */
    public function schools(): HasMany
    {
        return $this->hasMany(School::class);
    }

    /**
     * @param  Builder<District>  $query
     * @return Builder<District>
     */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $query) use ($user) {
            foreach ($user->roles as $role) {
                $scopeType = $role->pivot->scope_type;
                $scopeId = (int) $role->pivot->scope_id;

                if ($scopeType === ScopeType::DISTRICT->value) {
                    $query->orWhere('id', $scopeId);
                }

                if ($scopeType === ScopeType::PROVINCE->value) {
                    $query->orWhere('province_id', $scopeId);
                }
            }
        });
    }
}
