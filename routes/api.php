<?php

use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\RegistrationRequestController;
use App\Http\Controllers\Api\SchoolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Schools

Route::get('/schools', [
    SchoolController::class,
    'index',
])->middleware('auth:sanctum');

Route::get('/schools/{school}', [
    SchoolController::class,
    'show',
])->middleware('auth:sanctum');

Route::post('/schools', [
    SchoolController::class,
    'store',
])->middleware('auth:sanctum');

Route::patch('/schools/{school}', [
    SchoolController::class,
    'update',
])->middleware('auth:sanctum');

Route::delete('/schools/{school}', [
    SchoolController::class,
    'destroy',
])->middleware('auth:sanctum');

Route::post('/schools/{id}/restore', [
    SchoolController::class,
    'restore',
])->middleware('auth:sanctum');

// Districts

Route::get('/districts', [
    DistrictController::class,
    'index',
])->middleware('auth:sanctum');

Route::get('/districts/{district}', [
    DistrictController::class,
    'show',
])->middleware('auth:sanctum');

Route::post('/districts', [
    DistrictController::class,
    'store',
])->middleware('auth:sanctum');

Route::patch('/districts/{district}', [
    DistrictController::class,
    'update',
])->middleware('auth:sanctum');

Route::delete('/districts/{district}', [
    DistrictController::class,
    'destroy',
])->middleware('auth:sanctum');

Route::post('/districts/{id}/restore', [
    DistrictController::class,
    'restore',
])->middleware('auth:sanctum');

// Registration Requests

Route::post('/registration-requests', [
    RegistrationRequestController::class,
    'store',
]);

Route::get('/registration-requests', [
    RegistrationRequestController::class,
    'index',
])->middleware('auth:sanctum');

Route::post('/registration-requests/{registrationRequest}/approve', [
    RegistrationRequestController::class,
    'approve',
])->middleware('auth:sanctum');

Route::post('/registration-requests/{registrationRequest}/reject', [
    RegistrationRequestController::class,
    'reject',
])->middleware('auth:sanctum');
