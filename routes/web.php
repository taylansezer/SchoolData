<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
    Route::inertia('schools', 'schools/index')->name('schools.index');
    Route::inertia('schools/create', 'schools/create')->name('schools.create');
});

require __DIR__.'/settings.php';
