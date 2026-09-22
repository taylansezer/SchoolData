<?php

namespace App\Models;

use App\Enums\RegistrationRequestStatus;
use App\Enums\ScopeType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationRequest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'requested_role_id',
        'scope_type',
        'scope_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (RegistrationRequest $request) {
            $request->status ??= RegistrationRequestStatus::PENDING;
        });
    }

    protected function casts(): array
    {
        return [
            'scope_type' => ScopeType::class,
            'status' => RegistrationRequestStatus::class,
            'reviewed_at' => 'datetime',
        ];
    }

    public function requestedRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'requested_role_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $query) use ($user) {
            foreach ($user->roles as $role) {
                $scopeType = $role->pivot->scope_type;
                $scopeId = (int) $role->pivot->scope_id;

                if ($scopeType === ScopeType::PROVINCE) {
                    $query->orWhere(function (Builder $query) use ($scopeId) {
                        $query->where('scope_type', ScopeType::PROVINCE->value)
                            ->where('scope_id', $scopeId);
                    });

                    $query->orWhere(function (Builder $query) use ($scopeId) {
                        $query->where('scope_type', ScopeType::DISTRICT->value)
                            ->whereIn('scope_id', function ($subQuery) use ($scopeId) {
                                $subQuery->select('id')
                                    ->from('districts')
                                    ->where('province_id', $scopeId);
                            });
                    });

                    $query->orWhere(function (Builder $query) use ($scopeId) {
                        $query->where('scope_type', ScopeType::SCHOOL->value)
                            ->whereIn('scope_id', function ($subQuery) use ($scopeId) {
                                $subQuery->select('schools.id')
                                    ->from('schools')
                                    ->join(
                                        'districts',
                                        'districts.id',
                                        '=',
                                        'schools.district_id'
                                    )
                                    ->where('districts.province_id', $scopeId);
                            });
                    });
                }

                if ($scopeType === ScopeType::DISTRICT) {
                    $query->orWhere(function (Builder $query) use ($scopeId) {
                        $query->where('scope_type', ScopeType::DISTRICT->value)
                            ->where('scope_id', $scopeId);
                    });

                    $query->orWhere(function (Builder $query) use ($scopeId) {
                        $query->where('scope_type', ScopeType::SCHOOL->value)
                            ->whereIn('scope_id', function ($subQuery) use ($scopeId) {
                                $subQuery->select('id')
                                    ->from('schools')
                                    ->where('district_id', $scopeId);
                            });
                    });
                }
            }
        });
    }
}



