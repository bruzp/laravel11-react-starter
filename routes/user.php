<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AnswerController;
use App\Http\Controllers\User\ProfileController;

Route::get('/', function () {
    return Inertia::render('User/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('answers')->group(function () {
    Route::name('answers.')->group(function () {
        Route::get('/', [AnswerController::class, 'index'])->name('index');

        Route::delete('{answer}', [AnswerController::class, 'destroy'])->name('destroy');
    });
});
