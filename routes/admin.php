<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ConfessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\RegistrationImportController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.attempt');
    });

    Route::post('logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('registrations', [RegistrationController::class, 'index'])->name('registrations.index');
        Route::get('registrations/import', [RegistrationImportController::class, 'create'])
            ->name('registrations.import');
        Route::post('registrations/import', [RegistrationImportController::class, 'store'])
            ->name('registrations.import.store');
        Route::get('registrations/{registration:confirmation_token}', [RegistrationController::class, 'show'])
            ->name('registrations.show');

        Route::get('confessions', [ConfessionController::class, 'index'])->name('confessions.index');
        Route::patch('confessions/{confession}/toggle', [ConfessionController::class, 'toggleHidden'])
            ->name('confessions.toggle');

        Route::get('questions', [QuestionController::class, 'index'])->name('questions.index');
        Route::patch('questions/{question}/status', [QuestionController::class, 'updateStatus'])
            ->name('questions.status');
        Route::patch('questions/{question}/toggle', [QuestionController::class, 'toggleHidden'])
            ->name('questions.toggle');
    });
});
