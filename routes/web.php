<?php

use App\Http\Controllers\RetreatRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RetreatRegistrationController::class, 'index'])->name('landing');
Route::post('/register', [RetreatRegistrationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('registrations.store');
Route::get('/registration/{registration:confirmation_token}', [RetreatRegistrationController::class, 'show'])
    ->name('registrations.confirmation');
