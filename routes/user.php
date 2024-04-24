<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\User\AnswerController;
use App\Http\Controllers\User\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('answers')->group(function () {
        Route::name('answers.')->group(function () {
            Route::get('/', [AnswerController::class, 'index'])->name('index');

            #TODO: Implement function.
            Route::delete('{answer}', [AnswerController::class, 'destroy'])->name('destroy');
        });
    });

});
