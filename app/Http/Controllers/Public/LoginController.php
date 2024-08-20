<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Public;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Keating\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function create(): Response
    {
        return inertia("Public/Login", [
            "universityLogo" => asset("cwup-full.png"),
        ]);
    }

    public function store(Request $request, AuthManager $auth): RedirectResponse
    {
        $credentials = $request->only("email", "password");

        if ($auth->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route("dashboard");
        }

        return back()->withErrors([
            "email" => "Niepoprawne dane logowania",
        ]);
    }
}
