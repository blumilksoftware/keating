<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class LoginController extends Controller
{
    public function create(): Response
    {
        return inertia("Public/Login", [
            "department" => "Zakład Informatyki, Wydział Nauk Technicznych i Ekonomicznych",
            "university" => "Collegium Witelona Uczelnia Państwowa",
            "universityLogo" => "https://irg2023.collegiumwitelona.pl/assets/logos/cwup.png",
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            "email" => "Niepoprawne dane logowania",
        ]);
    }
}
