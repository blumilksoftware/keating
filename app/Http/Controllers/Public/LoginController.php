<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Public;

use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Keating\Actions\SendLoginLink;
use Keating\Models\PasswordlessAttempt;
use Keating\Models\User;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class LoginController
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

    public function passwordlessCreate(): Response
    {
        return inertia("Public/PasswordlessLogin", [
            "universityLogo" => asset("cwup-full.png"),
        ]);
    }

    public function passwordlessStore(Request $request, SendLoginLink $action): RedirectResponse
    {
        $time = Carbon::now()->addMinutes(5);
        PasswordlessAttempt::query()
            ->updateOrCreate(
                attributes: [
                    "email" => $request->email,
                ],
                values: [
                    "email" => $request->email,
                    "session_id" => $request->session()->getId(),
                    "can_login" => false,
                    "expires_at" => $time,
                ],
            );

        $action->handle(
            email: $request->email,
            time: $time,
        );

        return back();
    }

    public function passwordlessCheck(Request $request): JsonResponse
    {
        $passwordlessAttempt = PasswordlessAttempt::query()
            ->where("email", $request->email)
            ->where("can_login", true)
            ->where("expires_at", ">", Carbon::now())
            ->where("session_id", $request->session()->getId())
            ->first();

        if ($passwordlessAttempt === null) {
            return new JsonResponse([
                "can_login" => false,
            ], SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        $user = User::query()
            ->where("email", $request->email)
            ->first();

        Auth::login($user);

        return new JsonResponse([
            "can_login" => true,
        ], SymfonyResponse::HTTP_OK);
    }

    public function passwordlessLogin(Request $request, string $email): RedirectResponse
    {
        if (!$request->hasValidSignature()) {
            abort(SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        PasswordlessAttempt::query()
            ->where("email", $email)
            ->where("can_login", false)
            ->where("expires_at", ">", Carbon::now())
            ->update([
                "can_login" => true,
            ]);

        return redirect()->route("passwordless.create");
    }
}
