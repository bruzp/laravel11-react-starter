<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Admin\QuestionnairesController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;

Route::middleware('guest.admin')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth.admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('dashboard.index');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::prefix('users')->group(function () {
        Route::name('users.')->group(function () {
            Route::get('/', [UsersController::class, 'index'])->name('index');

            Route::get('create', [UsersController::class, 'create'])->name('create');
            Route::post('/', [UsersController::class, 'store'])->name('store');

            Route::get('{user}/edit', [UsersController::class, 'edit'])->name('edit');
            Route::put('{user}', [UsersController::class, 'update'])->name('update');

            Route::delete('{user}', [UsersController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('questionnaires')->group(function () {
        Route::name('questionnaires.')->group(function () {
            Route::get('/', [QuestionnairesController::class, 'index'])->name('index');

            Route::get('create', [QuestionnairesController::class, 'create'])->name('create');
            Route::post('/', [QuestionnairesController::class, 'store'])->name('store');

            Route::get('{questionnaire}/edit', [QuestionnairesController::class, 'edit'])->name('edit');
            Route::put('{questionnaire}', [QuestionnairesController::class, 'update'])->name('update');

            Route::delete('{questionnaire}', [QuestionnairesController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('questions')->group(function () {
        Route::name('questions.')->group(function () {
            Route::post('/{questionnaire}', [QuestionsController::class, 'store'])->name('store');

            Route::put('{question}', [QuestionsController::class, 'update'])->name('update');

            Route::delete('{question}', [QuestionsController::class, 'destroy'])->name('destroy');

            Route::get('reindex/{questionnaire}', [QuestionsController::class, 'reindex'])->name('reindex');
            Route::put('update/priority/{questionnaire}', [QuestionsController::class, 'updatePriority'])->name('update.priority');
        });
    });

    Route::prefix('answers')->group(function () {
        Route::name('answers.')->group(function () {
            Route::get('/', [AnswerController::class, 'index'])->name('index');

            Route::delete('{question}', [QuestionsController::class, 'destroy'])->name('destroy');
        });
    });
});
