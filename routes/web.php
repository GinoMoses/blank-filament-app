<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/{examTest}', [ExamController::class, 'show'])->name('exams.show');
    Route::post('/exams/{examTest}/submit-answer', [ExamController::class, 'submitAnswer'])->name('exams.submit-answer');
    Route::post('/exams/{examTest}/submit', [ExamController::class, 'submit'])->name('exams.submit');
    Route::get('/exams/{examTest}/attempts/{attempt}/results', [ExamController::class, 'results'])->name('exams.results');
});
