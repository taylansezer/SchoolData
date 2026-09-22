<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
             return [
            'id' => $this->id,
            'name' => $this->name,

            'district' => [
                'id' => $this->district->id,
                'name' => $this->district->name,
            ],

            'school_type' => [
                'id' => $this->schoolType->id,
                'name' => $this->schoolType->name,
            ],

            'ownership_type' => $this->ownership_type,

            'address' => $this->address,
            'phone' => $this->phone,
            'website' => $this->website,

            'student_count' => $this->student_count,
            'teacher_count' => $this->teacher_count,
            'classroom_count' => $this->classroom_count,

            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            ];
    }
}
