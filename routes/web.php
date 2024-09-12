<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\DeviceTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('device_types', DeviceTypeController::class);
    Route::resource('areas', AreaController::class);
});
