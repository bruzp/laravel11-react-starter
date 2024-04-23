<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;

class ExamController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        return Inertia::render('Frontend/Exam/Index');
    }
}
