<?php

namespace App\Models;

use App\Enums\ScopeType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'district_id',
        'directorate_id',
        'institution_code',
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

    /**
     * @return BelongsTo<District, $this>
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * @return BelongsTo<SchoolType, $this>
     */
    public function schoolType(): BelongsTo
    {
        return $this->belongsTo(SchoolType::class);
    }

    /**
     * @return BelongsTo<Directorate, $this>
     */
    public function directorate(): BelongsTo
    {
        return $this->belongsTo(Directorate::class);
    }

    /**
     * @param  Builder<School>  $query
     * @return Builder<School>
     */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $query) use ($user) {
            foreach ($user->roles as $role) {
                $scopeType = $role->pivot->scope_type;
                $scopeId = (int) $role->pivot->scope_id;

                if ($scopeType === ScopeType::SCHOOL->value) {
                    $query->orWhere('id', $scopeId);
                }

                if ($scopeType === ScopeType::DISTRICT->value) {
                    $query->orWhere('district_id', $scopeId);
                }

                if ($scopeType === ScopeType::PROVINCE->value) {
                    $query->orWhereHas('district', function (Builder $query) use ($scopeId) {
                        $query->where('province_id', $scopeId);
                    });
                }
            }
        });
    }
}
