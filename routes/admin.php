<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
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
            Route::controller(UsersController::class)->group(function () {
                Route::get('/', 'index')->name('index');

                Route::get('create', 'create')->name('create');
                Route::post('/', 'store')->name('store');

                Route::get('{user}/edit', 'edit')->name('edit');
                Route::put('{user}', 'update')->name('update');

                Route::delete('{user}', 'destroy')->name('destroy');
            });
        });
    });

    Route::prefix('questionnaires')->group(function () {
        Route::name('questionnaires.')->group(function () {
            Route::controller(QuestionnairesController::class)->group(function () {
                Route::get('/', 'index')->name('index');

                Route::get('create', 'create')->name('create');
                Route::post('/', 'store')->name('store');

                Route::get('{questionnaire}/edit', 'edit')->name('edit');
                Route::put('{questionnaire}', 'update')->name('update');

                Route::delete('{questionnaire}', 'destroy')->name('destroy');
            });
        });
    });
});
