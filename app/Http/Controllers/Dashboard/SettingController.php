<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Keating\Http\Controllers\Controller;
use Keating\Http\Requests\SettingRequest;
use Keating\Models\Setting;

class SettingController extends Controller
{
    public function edit(): Response
    {
        return inertia("Dashboard/Setting/Edit", [
            "settings" => Setting::query()->first(),
        ]);
    }

    public function update(SettingRequest $request, FilesystemManager $filesystem): RedirectResponse
    {
        $settings = Setting::query()->firstOrFail();
        $settings->fill($request->getData());

        if ($request->file("logo")) {
            if ($settings->logo) {
                $filesystem->disk("public")->delete($settings->logo);
            }
            $file = $request->file("logo");
            $fileName = $file->getClientOriginalName();
            $path = "/logo";

            $fullPath = $filesystem->disk("public")->putFileAs($path, $file, $fileName);
            $settings->logo = $fullPath;
        }

        $settings->save();

        return redirect()
            ->back()
            ->with("success", "Zaktualizowano ustawienia");
    }

    public function removeLogo(FilesystemManager $filesystem): RedirectResponse
    {
        $settings = Setting::query()->firstOrFail();

        if ($settings->logo) {
            $filesystem->disk("public")->delete($settings->logo);

            $settings->logo = null;
            $settings->save();

            return redirect()
                ->back()
                ->with("success", "Usunięto logo");
        }

        abort(404);
    }
}
