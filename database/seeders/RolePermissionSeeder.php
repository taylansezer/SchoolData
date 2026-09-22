<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $rolePermissions = [
            'super-admin' => [
                'school.view',
                'school.create',
                'school.update',
                'school.delete',
                'school.restore',

                'user.view',
                'user.create',
                'user.disable',

                'registration.view',
                'registration.approve',
                'registration.reject',

                'report.view',
                'report.export',

                'district.view',
                'district.create',
                'district.update',
                'district.delete',
                'district.restore',
            ],

            'admin' => [
                'school.view',
                'school.create',
                'school.update',
                'school.delete',
                'school.restore',

                'user.view',
                'user.create',
                'user.disable',

                'registration.view',
                'registration.approve',
                'registration.reject',

                'report.view',
                'report.export',

                'district.view',
            ],

            'data-entry' => [
                'school.view',
                'school.create',
                'school.update',

                'report.view',
                'report.export',

                'district.view',
            ],

            'viewer' => [
                'school.view',
                'report.view',
                'district.view',

            ],
        ];

        foreach ($rolePermissions as $roleSlug => $permissionSlugs) {
            $role = Role::where('slug', $roleSlug)->firstOrFail();

            $permissionIds = Permission::whereIn('slug', $permissionSlugs)
                ->pluck('id');

            $role->permissions()->sync($permissionIds);
        }
    }
}
