<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;

class IndexController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        return Inertia::render('User/Dashboard', [
            'rank' => $request->user()->rank,
        ]);
    }
}
