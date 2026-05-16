<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Public;

use Carbon\Carbon;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Keating\Actions\PasswordlessCheckAndClearAttemptAction;
use Keating\Actions\SendLoginLink;
use Keating\Models\PasswordlessAttempt;
use Keating\Models\User;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class PasswordlessLoginController
{
    public function create(): Response
    {
        return inertia("Public/PasswordlessLogin", [
            "universityLogo" => asset("cwup-full.png"),
        ]);
    }

    public function store(Request $request, SendLoginLink $action): RedirectResponse
    {
        $user = User::query()->where("email", $request->get("email"))->first();

        if ($user === null) {
            return $this->redirectToPasswordlessCreate();
        }

        $time = Carbon::now()->addMinutes(5);
        PasswordlessAttempt::query()
            ->updateOrCreate(
                attributes: [
                    "email" => $request->get("email"),
                ],
                values: [
                    "email" => $request->get("email"),
                    "session_id" => $request->session()->getId(),
                    "can_login" => false,
                    "expires_at" => $time,
                ],
            );

        $action->handle(
            email: $request->email,
            time: $time,
        );

        return $this->redirectToPasswordlessCreate();
    }

    public function check(Request $request, string $email, PasswordlessCheckAndClearAttemptAction $action, AuthManager $auth): JsonResponse
    {
        $canLogin = $action->handle(
            email: $email,
            sessionId: $request->session()->getId(),
        );

        if (!$canLogin) {
            return new JsonResponse([
                "can_login" => false,
            ], SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        $user = User::query()
            ->where("email", $email)
            ->first();

        $auth->login($user);
        $request->session()->regenerate();

        return new JsonResponse([
            "can_login" => true,
        ], SymfonyResponse::HTTP_OK);
    }

    public function login(Request $request, string $email): RedirectResponse
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

        return redirect()->route("passwordless.create")
            ->with("success", "Potwierdzono logowanie.");
    }

    private function redirectToPasswordlessCreate(): RedirectResponse
    {
        return redirect()->route("passwordless.create")
            ->with("success", "Jeśli podany adres e-mail istnieje w naszej bazie, otrzymasz link do logowania.");
    }
}
