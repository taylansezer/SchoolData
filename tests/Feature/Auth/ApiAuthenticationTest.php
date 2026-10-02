<?php

use App\Models\User;

it('users can authenticate through the API', function () {
    $user = User::factory()->create([
        'email' => 'api-test@example.com',
        'password' => 'password',
        'is_active' => true,
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response
        ->assertOk()
        ->assertJsonStructure([
            'message',
            'token',
            'user' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'is_active',
                'last_login_at',
            ],
        ]);

    expect($response->json('token'))->not->toBeEmpty();
    expect($user->fresh()->last_login_at)->not->toBeNull();
});

it('cannot authenticate through the API with invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'api-test@example.com',
        'password' => 'password',
        'is_active' => true,
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response
        ->assertStatus(401)
        ->assertJson([
            'message' => 'The provided credentials are incorrect.',
        ]);
});

it('cannot authenticate through the API with an inactive account', function () {
    $user = User::factory()->create([
        'email' => 'api-test@example.com',
        'password' => 'password',
        'is_active' => false,
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response
        ->assertStatus(403)
        ->assertJson([
            'message' => 'Your account is inactive.',
        ]);

    expect($user->fresh()->last_login_at)->toBeNull();
});

it('requires email and password for API login', function () {
    $response = $this->postJson('/api/login', []);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'email',
            'password',
        ]);
});

it('users can logout through the API', function () {
    $user = User::factory()->create([
        'email' => 'api-test@example.com',
        'password' => 'password',
        'is_active' => true,
    ]);

    $token = $user->createToken('api-test')->plainTextToken;

    $this->withToken($token)
        ->postJson('/api/logout')
        ->assertOk()
        ->assertJson([
            'message' => 'Logout successful.',
        ]);

    $this->assertDatabaseCount('personal_access_tokens', 0);
});
