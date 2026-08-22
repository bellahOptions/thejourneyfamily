<?php

use App\Http\Controllers\ConfessionController;
use App\Http\Controllers\ConsultationBookingController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RetreatRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RetreatRegistrationController::class, 'index'])->name('landing');

Route::get('/register', [RetreatRegistrationController::class, 'create'])->name('registrations.create');
Route::post('/register', [RetreatRegistrationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('registrations.store');
Route::get('/registration/{registration:confirmation_token}', [RetreatRegistrationController::class, 'show'])
    ->name('registrations.confirmation');

Route::get('/confessions', [ConfessionController::class, 'index'])->name('confessions.index');
Route::post('/confessions', [ConfessionController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('confessions.store');

Route::get('/ask', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/ask', [QuestionController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('questions.store');
Route::get('/questions/live', [QuestionController::class, 'live'])->name('questions.live');
Route::get('/questions/live-data', [QuestionController::class, 'liveData'])->name('questions.live-data');

Route::get('/consultation', [ConsultationBookingController::class, 'create'])->name('consultations.create');
Route::post('/consultation', [ConsultationBookingController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('consultations.store');

require __DIR__.'/admin.php';
