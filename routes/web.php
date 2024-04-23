<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Frontend\QuestionnaireController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::get('/exams', [QuestionnaireController::class, 'index'])->name('exams');

Route::get('take-exam/{questionnaire}', [QuestionnaireController::class, 'create'])->name('take-exam');

require __DIR__ . '/auth.php';
