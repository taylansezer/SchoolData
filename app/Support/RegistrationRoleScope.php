<?php

namespace App\Support;

use App\Enums\ScopeType;


class RegistrationRoleScope
{
    public static function isAllowed(string $roleSlug, string $scopeType): bool
    {
        return match ($roleSlug) {
            'admin' => $scopeType === ScopeType::DISTRICT->value,

            'data-entry',
            'viewer' => in_array($scopeType, [
                ScopeType::DISTRICT->value,
                ScopeType::SCHOOL->value,
            ], true),

            'super-admin' => false,

            default => false,
        };
    }
}
