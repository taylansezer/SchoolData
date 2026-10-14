<?php

use App\Http\Controllers\Web\SchoolController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    Route::get('schools', [SchoolController::class, 'index'])
        ->name('schools.index');

    Route::get('schools/create', [SchoolController::class, 'create'])
        ->name('schools.create');

    Route::post('schools', [SchoolController::class, 'store'])
        ->name('schools.store');
});

require __DIR__.'/settings.php';
