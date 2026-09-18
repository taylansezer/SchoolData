<?php

namespace App\Models;

use App\Enums\RegistrationRequestStatus;
use App\Enums\ScopeType;
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
}
