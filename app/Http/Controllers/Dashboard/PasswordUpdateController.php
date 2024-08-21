<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Inertia\Response;

class PasswordUpdateController
{
    public function edit(): Response
    {
        return inertia("Dashboard/PasswordUpdate");
    }

    public function update(Request $request, Hasher $hasher): RedirectResponse
    {
        $validated = $request->validate([
            "current_password" => ["required", "current_password"],
            "password" => ["required", Password::defaults(), "confirmed"],
        ]);

        $request->user()->update([
            "password" => $hasher->make($validated["password"]),
        ]);

        return redirect()->back()
            ->with("success", "Zaktualizowano hasło");
    }
}
