<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SectionSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SectionSettingsController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        SectionSettings::query()->first()
            ->update([
                "banner_enabled" => $request->boolean("banner_enabled"),
                "about_enabled" => $request->boolean("about_enabled"),
                "counters_enabled" => $request->boolean("counters_enabled"),
                "contact_enabled" => $request->boolean("contact_enabled"),
            ]);

        return redirect()
            ->back()
            ->with("success", "Zaktualizowano ustawienia sekcji");
    }
}
