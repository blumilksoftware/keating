<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
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
        $settings = Setting::query()->firstOrFail();
        $settings->fill($request->getData());

        if ($request->file("logo")) {
            if ($settings->logo) {
                Storage::disk("public")->delete($settings->logo);
            }
            $file = $request->file("logo");
            $fileName = $file->getClientOriginalName();
            $path = "/logo";

            $fullPath = Storage::disk("public")->putFileAs($path, $file, $fileName);
            $settings->logo = $fullPath;
        }

        $settings->save();

        return redirect()
            ->back()
            ->with("success", "Zaktualizowano ustawienia");
    }

    public function removeLogo(): RedirectResponse
    {
        $settings = Setting::query()->firstOrFail();

        if ($settings->logo) {
            Storage::disk("public")->delete($settings->logo);
            $settings->logo = null;
            $settings->save();

            return redirect()
                ->back()
                ->with("success", "Usunięto logo");
        }

        abort(404);
    }
}
