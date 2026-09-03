<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class School extends Model
{
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
}
