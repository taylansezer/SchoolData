<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'district_id',
        'school_type_id',
        'name',
        'address',
        'phone',
        'website',
        'ownership_type',
        'student_count',
        'teacher_count',
        'classroom_count',
        'latitude',
        'longitude',
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
    public function schoolType(): BelongsTo
    {
        return $this->belongsTo(SchoolType::class);
    }

     public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $query) use ($user) {
            foreach ($user->roles as $role) {
                $scopeType = $role->pivot->scope_type;
                $scopeId = (int) $role->pivot->scope_id;

                if ($scopeType === \App\Enums\ScopeType::SCHOOL) {
                    $query->orWhere('id', $scopeId);
                }

                if ($scopeType === \App\Enums\ScopeType::DISTRICT) {
                    $query->orWhere('district_id', $scopeId);
                }

                if ($scopeType === \App\Enums\ScopeType::PROVINCE) {
                    $query->orWhereHas('district', function (Builder $query) use ($scopeId) {
                        $query->where('province_id', $scopeId);
                    });
                }
            }
        });
    }
}
