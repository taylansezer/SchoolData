<?php

namespace App\Policies;

use App\Enums\ScopeType;
use App\Models\District;
use App\Models\User;

class DistrictPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->hasPermission('district.view');
    }

    public function view(User $user, District $district): bool
    {
        if (! $user->hasPermission('district.view')) {
            return false;
        }

        foreach ($user->roles as $role) {
            $scopeType = $role->pivot->scope_type;
            $scopeId = (int) $role->pivot->scope_id;

            if ($scopeType === ScopeType::DISTRICT) {
                if ($district->id === $scopeId) {
                    return true;
                }
            }

            if ($scopeType === ScopeType::PROVINCE) {
                if ($district->province_id === $scopeId) {
                    return true;
                }
            }
        }

        return false;
    }


    public function create(User $user): bool
    {
        return $user->hasPermission('district.create');
    }

    public function update(User $user, District $district): bool
    {
        return $user->hasPermission('district.update');
    }

    public function delete(User $user, District $district): bool
    {
        return $user->hasPermission('district.delete');
    }

    public function restore(User $user, District $district): bool
    {
        return $user->hasPermission('district.restore');
    }

    public function forceDelete(User $user, District $district): bool
    {
        return false;
    }

}
