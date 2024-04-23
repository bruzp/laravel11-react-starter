<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Frontend\QuestionnairesController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::get('/exams', [QuestionnairesController::class, 'index'])->name('exams');

Route::get('take-exam/{questionnaire}', [QuestionnairesController::class, 'create'])->name('take-exam');
Route::post('check-exam/{questionnaire}', [QuestionnairesController::class, 'store'])->name('check-exam');

require __DIR__ . '/auth.php';
