<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Keating\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __invoke(Request $request, AuthManager $auth): RedirectResponse
    {
        $auth->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route("main");
    }
}
