<?php

namespace App\Policies;

use App\Enums\RegistrationRequestStatus;
use App\Enums\ScopeType;
use App\Models\District;
use App\Models\RegistrationRequest;
use App\Models\School;
use App\Models\User;

class RegistrationRequestPolicy
{
    /**
     * Determine whether the user can view any registration requests.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('registration.view');
    }

    /**
     * Determine whether the user can view the registration request.
     */
    public function view(
        User $user,
        RegistrationRequest $registrationRequest
    ): bool {
        if (! $user->hasPermission('registration.view')) {
            return false;
        }

        return $this->hasScopeAccess($user, $registrationRequest);
    }

    /**
     * Determine whether the user can approve the registration request.
     */
    public function approve(
        User $user,
        RegistrationRequest $registrationRequest
    ): bool {
        if (! $user->hasPermission('registration.approve')) {
            return false;
        }

        if ($registrationRequest->status !== RegistrationRequestStatus::PENDING) {
            return false;
        }

        return $this->hasApprovalScopeAccess($user, $registrationRequest);
    }

    /**
     * Determine whether the user can reject the registration request.
     */
    public function reject(
        User $user,
        RegistrationRequest $registrationRequest
    ): bool {
        if (! $user->hasPermission('registration.reject')) {
            return false;
        }

        if ($registrationRequest->status !== RegistrationRequestStatus::PENDING) {
            return false;
        }

        return $this->hasApprovalScopeAccess($user, $registrationRequest);
    }

    private function hasScopeAccess(
        User $user,
        RegistrationRequest $registrationRequest
    ): bool {
        foreach ($user->roles as $role) {
            $scopeType = $role->pivot->scope_type;
            $scopeId = (int) $role->pivot->scope_id;

            if ($scopeType === ScopeType::PROVINCE) {
                if (
                    $registrationRequest->scope_type === ScopeType::PROVINCE
                    && (int) $registrationRequest->scope_id === $scopeId
                ) {
                    return true;
                }

                if ($registrationRequest->scope_type === ScopeType::DISTRICT) {
                    $district = District::find($registrationRequest->scope_id);

                    if ($district && $district->province_id === $scopeId) {
                        return true;
                    }
                }

                if ($registrationRequest->scope_type === ScopeType::SCHOOL) {
                    $school = School::find($registrationRequest->scope_id);

                    if (
                        $school
                        && $school->district
                        && $school->district->province_id === $scopeId
                    ) {
                        return true;
                    }
                }
            }

            if ($scopeType === ScopeType::DISTRICT) {
                if (
                    $registrationRequest->scope_type === ScopeType::DISTRICT
                    && (int) $registrationRequest->scope_id === $scopeId
                ) {
                    return true;
                }

                if ($registrationRequest->scope_type === ScopeType::SCHOOL) {
                    $school = School::find($registrationRequest->scope_id);

                    if ($school && $school->district_id === $scopeId) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function hasApprovalScopeAccess(
        User $user,
        RegistrationRequest $registrationRequest
    ): bool {
        foreach ($user->roles as $role) {
            $scopeType = $role->pivot->scope_type;
            $scopeId = (int) $role->pivot->scope_id;

            if ($scopeType === ScopeType::PROVINCE) {
                return $this->hasScopeAccess($user, $registrationRequest);
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
}
