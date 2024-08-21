<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Keating\Enums\SectionType;
use Keating\Http\Requests\SectionRequest;
use Keating\Models\Section;
use Keating\Models\SectionSettings;
use Spatie\LaravelOptions\Options;

class SectionController
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
