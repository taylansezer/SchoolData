<?php

namespace App\Policies;

use App\Enums\ScopeType;
use App\Models\District;
use App\Models\School;
use App\Models\User;

class SchoolPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('school.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, School $school): bool
    {
        return $user->hasPermission('school.view')
          && $this->hasSchoolScope($user, $school);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(User $user, array $attributes): bool
    {
        return $user->hasPermission('school.create')
            && $this->canCreateInScope($user, $attributes);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, School $school): bool
    {
        return $user->hasPermission('school.update')
            && $this->hasSchoolScope($user, $school);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, School $school): bool
    {
        return $user->hasPermission('school.delete')
            && $this->hasSchoolScope($user, $school);

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, School $school): bool
    {
        return $user->hasPermission('school.restore')
            && $this->hasSchoolScope($user, $school);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, School $school): bool
    {
        return false;
    }

    private function hasSchoolScope(User $user, School $school): bool
    {
        foreach ($user->roles as $role) {
            $scopeType = $role->pivot->scope_type;
            $scopeId = (int) $role->pivot->scope_id;

            if ($scopeType === ScopeType::SCHOOL->value) {
                if ($scopeId === $school->id) {
                    return true;
                }
            }

            if ($scopeType === ScopeType::DISTRICT->value) {
                if ($scopeId === $school->district_id) {
                    return true;
                }
            }

            if ($scopeType === ScopeType::PROVINCE->value) {
                if ($school->district->province_id === $scopeId) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function canCreateInScope(User $user, array $attributes): bool
    {
        if (! isset($attributes['district_id'])) {
            return false;
        }

        $districtId = (int) $attributes['district_id'];

        foreach ($user->roles as $role) {
            $scopeType = $role->pivot->scope_type;
            $scopeId = (int) $role->pivot->scope_id;

            if ($scopeType === ScopeType::SCHOOL->value) {
                continue;
            }

            if ($scopeType === ScopeType::DISTRICT->value) {
                if ($districtId === $scopeId) {
                    return true;
                }
            }

            if ($scopeType === ScopeType::PROVINCE->value) {
                $district = District::find($districtId);

                if ($district && $district->province_id === $scopeId) {
                    return true;
                }
            }
        }

        return false;
    }
}
