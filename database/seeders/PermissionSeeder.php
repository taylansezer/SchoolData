<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'View Schools',
                'slug' => 'school.view',
            ],
            [
                'name' => 'Create Schools',
                'slug' => 'school.create',
            ],
            [
                'name' => 'Update Schools',
                'slug' => 'school.update',
            ],
            [
                'name' => 'Delete Schools',
                'slug' => 'school.delete',
            ],
            [
                'name' => 'Restore Schools',
                'slug' => 'school.restore',
            ],
            [
                'name' => 'View Users',
                'slug' => 'user.view',
            ],
            [
                'name' => 'Create Users',
                'slug' => 'user.create',
            ],
            [
                'name' => 'Disable Users',
                'slug' => 'user.disable',
            ],
            [
                'name' => 'View Registration Requests',
                'slug' => 'registration.view',
            ],
            [
                'name' => 'Approve Registration Requests',
                'slug' => 'registration.approve',
            ],
            [
                'name' => 'Reject Registration Requests',
                'slug' => 'registration.reject',
            ],
            [
                'name' => 'View Reports',
                'slug' => 'report.view',
            ],
            [
                'name' => 'Export Reports',
                'slug' => 'report.export',
            ],
            [
                'name' => 'View Districts',
                'slug' => 'district.view',
            ],
            [
                'name' => 'Create Districts',
                'slug' => 'district.create',
            ],
            [
                'name' => 'Update Districts',
                'slug' => 'district.update',
            ],
            [
                'name' => 'Delete Districts',
                'slug' => 'district.delete',
            ],
            [
                'name' => 'Restore Districts',
                'slug' => 'district.restore',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                ['name' => $permission['name']]
            );
        }
    }
}
