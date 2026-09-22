<?php

namespace App\Http\Requests\Api;

use App\Enums\RegistrationRequestStatus;
use App\Enums\ScopeType;
use App\Models\RegistrationRequest;
use App\Models\Role;
use App\Models\User;
use App\Support\RegistrationRoleScope;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class RegistrationRequestStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower(trim($this->input('email'))),
        ]);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],

            'requested_role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id')
                    ->where(function ($query) {
                        $query->where('slug', '!=', 'super-admin');
                    }),
            ],

            'scope_type' => [
                'required',
                Rule::enum(ScopeType::class),
            ],

            'scope_id' => [
                'required',
                'integer',
                $this->scopeExistsRule(),
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->hasAny(['requested_role_id', 'scope_type', 'scope_id'])) {
                return;
            }

            $email = $this->input('email');

            if (User::where('email', $email)->exists()) {
                $validator->errors()->add(
                    'email',
                    'A user with this email address already exists.'
                );

                return;
            }

            if (RegistrationRequest::where('email', $email)
                ->whereIn('status', [
                    RegistrationRequestStatus::PENDING,
                    RegistrationRequestStatus::APPROVED,
                ])
                ->exists()) {
                $validator->errors()->add(
                    'email',
                    'There is already an active registration for this email address.'
                );

                return;
            }

            $role = Role::find($this->integer('requested_role_id'));

            if (! $role) {
                return;
            }

            if (! RegistrationRoleScope::isAllowed(
                $role->slug,
                $this->input('scope_type')
            )) {
                $validator->errors()->add(
                    'scope_type',
                    'The selected role cannot use this scope.'
                );
            }
        });
    }
    private function scopeExistsRule()
    {
        return match ($this->input('scope_type')) {
            ScopeType::PROVINCE->value => Rule::exists('provinces', 'id'),

            ScopeType::DISTRICT->value => Rule::exists('districts', 'id')
                ->whereNull('deleted_at'),

            ScopeType::SCHOOL->value => Rule::exists('schools', 'id')
                ->whereNull('deleted_at'),

            default => Rule::in([]),
        };
    }
}
