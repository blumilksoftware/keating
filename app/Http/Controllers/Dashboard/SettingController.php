<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class SettingController extends Controller
{
    public function edit(): Response
    {
        return inertia("Dashboard/Setting/Edit", [
            "settings" => Setting::query()->first(),
        ]);
    }

    public function update(SettingRequest $request): RedirectResponse
    {
        Setting::query()->first()
            ->update($request->validated());

        return redirect()
            ->back()
            ->with("success", "Zaktualizowano ustawienia");
    }
}
