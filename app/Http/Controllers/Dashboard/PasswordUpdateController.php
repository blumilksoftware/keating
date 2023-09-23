<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Response;

class PasswordUpdateController extends Controller
{
    public function edit(): Response
    {
        return inertia("Dashboard/PasswordUpdate");
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "current_password" => ["required", "current_password"],
            "password" => ["required", Password::defaults(), "confirmed"],
        ]);

        $request->user()->update([
            "password" => Hash::make($validated["password"]),
        ]);

        return redirect()->back()
            ->with("success", "Zaktualizowano hasło");
    }
}
