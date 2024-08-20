<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Keating\Http\Controllers\Controller;
use Keating\Http\Requests\FieldRequest;
use Keating\Models\Field;

class FieldController extends Controller
{
    public function index(): Response
    {
        $fields = Field::query()
            ->orderBy("abbreviation")
            ->get();

        return inertia("Dashboard/Field/Index", [
            "fields" => $fields,
            "total" => Field::query()->count(),
            "lastUpdate" => Field::query()->orderByDesc("updated_at")->first()?->updated_at->diffForHumans(),
        ]);
    }

    public function create(): Response
    {
        return inertia("Dashboard/Field/Create");
    }

    public function store(FieldRequest $request): RedirectResponse
    {
        Field::query()->create($request->validated());

        return redirect()
            ->route("fields.index")
            ->with("success", "Dodano kierunek");
    }

    public function edit(Field $field): Response
    {
        return inertia("Dashboard/Field/Edit", [
            "field" => $field,
        ]);
    }

    public function update(FieldRequest $request, Field $field): RedirectResponse
    {
        $field->update($request->validated());

        return redirect()
            ->route("fields.index")
            ->with("success", "Zaktualizowano kierunek");
    }

    public function destroy(Field $field): RedirectResponse
    {
        $field->delete();

        return redirect()->back()
            ->with("success", "Usunięto kierunek");
    }
}
