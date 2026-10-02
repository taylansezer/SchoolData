<?php

use App\Models\Directorate;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Database\Seeders\DirectorateSeeder;
use Database\Seeders\DistrictSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\ProvinceSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SchoolTypeSeeder;

test('unauthenticated users cannot access schools API', function () {
    $response = $this->getJson('/api/schools');

    $response->assertUnauthorized();
});

test('users without school view permission cannot access schools API', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->getJson('/api/schools');

    $response->assertForbidden();
});

test('users with school view permission can access schools API', function () {
    $this->seed([
        PermissionSeeder::class,
        RoleSeeder::class,
        RolePermissionSeeder::class,
    ]);

    $role = Role::where('slug', 'admin')->firstOrFail();

    $user = User::factory()->create();

    $user->roles()->attach($role->id, [
        'scope_type' => 'province',
        'scope_id' => 1,
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson('/api/schools');

    $response->assertOk();
});

test('schools API returns directorate information', function () {
    $this->seed([
        ProvinceSeeder::class,
        DistrictSeeder::class,
        PermissionSeeder::class,
        RoleSeeder::class,
        RolePermissionSeeder::class,
        SchoolTypeSeeder::class,
        DirectorateSeeder::class,
    ]);

    $directorate = Directorate::where(
        'name',
        'Temel Eğitim Genel Müdürlüğü'
    )->firstOrFail();

    School::create([
        'district_id' => 1,
        'directorate_id' => $directorate->id,
        'institution_code' => 10000001,
        'school_type_id' => 1,
        'name' => 'Test Anaokulu',
        'ownership_type' => 'resmi',
    ]);

    $role = Role::where('slug', 'admin')->firstOrFail();

    $user = User::factory()->create();

    $user->roles()->attach($role->id, [
        'scope_type' => 'province',
        'scope_id' => 1,
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson('/api/schools');

    $response
        ->assertOk()
        ->assertJsonFragment([
            'id' => $directorate->id,
            'name' => $directorate->name,
        ]);
});
