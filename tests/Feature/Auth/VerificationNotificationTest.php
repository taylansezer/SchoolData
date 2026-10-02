<?php

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::emailVerification());
});

test('sends verification notification', function () {
    Notification::fake();

    $user = User::factory()->unverified()->create();

    $this->get(route('home'));

    $this->actingAs($user)
        ->post(route('verification.send'), [
            '_token' => csrf_token(),
        ])
        ->assertRedirect(route('home'));

    Notification::assertSentTo($user, VerifyEmail::class);
});

test('does not send verification notification if email is verified', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->get(route('home'));
    $this->actingAs($user)
        ->post(route('verification.send'), [
            '_token' => csrf_token(),
        ])
        ->assertRedirect(route('dashboard', absolute: false));

    Notification::assertNothingSent();
});
