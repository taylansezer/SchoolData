<?php

namespace App\Policies;

use App\Enums\RegistrationRequestStatus;
use App\Enums\ScopeType;
use App\Models\RegistrationRequest;
use App\Models\User;

class RegistrationRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('registration.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RegistrationRequest $registrationRequest): bool
    {
        if (! $user->hasPermission('registration.view')) {
            return false;
            }

        foreach ($user->roles as $role) {
            $scopeType = $role->pivot->scope_type;
            $scopeId = (int) $role->pivot->scope_id;

            // Super Admin / province scope
            if ($scopeType === ScopeType::PROVINCE) {
                return true;
            }

            // Admin / district scope
            if ($scopeType === ScopeType::DISTRICT) {
                if (
                    $registrationRequest->scope_type === ScopeType::DISTRICT
                    && (int) $registrationRequest->scope_id === $scopeId
                ) {
                    return true;
                }
            }
        }
        return false;
    }

    public function approve( User $user, RegistrationRequest $registrationRequest ): bool {
        if (! $user->hasPermission('registration.approve')) {
            return false;
        }

        if ($registrationRequest->status !== RegistrationRequestStatus::PENDING) {
            return false;
        }

        foreach ($user->roles as $role) {
            $scopeType = $role->pivot->scope_type;
            $scopeId = (int) $role->pivot->scope_id;

            if ($scopeType === ScopeType::PROVINCE) {
                return true;
            }

            if ($scopeType === ScopeType::DISTRICT) {
                if (
                    $registrationRequest->scope_type === ScopeType::DISTRICT
                    && (int) $registrationRequest->scope_id === $scopeId
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    public function reject(User $user, RegistrationRequest $registrationRequest): bool {
        if (! $user->hasPermission('registration.reject')) {
            return false;
        }

        if ($registrationRequest->status !== RegistrationRequestStatus::PENDING) {
            return false;
        }

        foreach ($user->roles as $role) {
            $scopeType = $role->pivot->scope_type;
            $scopeId = (int) $role->pivot->scope_id;

            if ($scopeType === ScopeType::PROVINCE) {
                return true;
            }

            if ($scopeType === ScopeType::DISTRICT) {
                if (
                    $registrationRequest->scope_type === ScopeType::DISTRICT
                    && (int) $registrationRequest->scope_id === $scopeId
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RegistrationRequest $registrationRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RegistrationRequest $registrationRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RegistrationRequest $registrationRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RegistrationRequest $registrationRequest): bool
    {
        return false;
    }
}



