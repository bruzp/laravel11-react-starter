<?php

namespace App\Http\Controllers\User\Auth;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('user.dashboard', absolute: false))
            : Inertia::render('User/Auth/VerifyEmail', ['status' => session('status')]);
    }
}
