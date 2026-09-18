<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SchoolStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'district_id' => ['required', 'integer', 'exists:districts,id'],
            'school_type_id' => ['required', 'integer', 'exists:school_types,id'],

            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'url', 'max:255'],

            'ownership_type' => ['required', 'in:resmi,özel'],

            'student_count' => ['nullable', 'integer', 'min:0'],
            'teacher_count' => ['nullable', 'integer', 'min:0'],
            'classroom_count' => ['nullable', 'integer', 'min:0'],

            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }
}
