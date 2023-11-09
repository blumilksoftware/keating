<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Enums\SectionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Section;
use App\Models\SectionSettings;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Spatie\LaravelOptions\Options;

class SectionController extends Controller
{
    public function show(): Response
    {
        return inertia("Dashboard/Section/Show", [
            "sectionTypes" => Options::forEnum(SectionType::class)->toArray(),
            "sectionSettings" => SectionSettings::query()->first(),
            "about" => Section::query()->about()->orderBy("created_at")->get(),
            "counters" => Section::query()->counter()->orderBy("created_at")->get(),
        ]);
    }

    public function store(SectionRequest $request): RedirectResponse
    {
        Section::query()->create($request->validated());

        return redirect()
            ->back()
            ->with("success", "Dodano sekcję");
    }

    public function update(SectionRequest $request, Section $section): RedirectResponse
    {
        $section->update($request->validated());

        return redirect()
            ->back()
            ->with("success", "Zaktualizowano sekcję");
    }

    public function destroy(Section $section): RedirectResponse
    {
        $section->delete();

        return redirect()
            ->back()
            ->with("success", "Usunięto sekcję");
    }
}
