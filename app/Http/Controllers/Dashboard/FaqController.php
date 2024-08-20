<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Keating\Http\Controllers\Controller;
use Keating\Http\Requests\FaqRequest;
use Keating\Models\Faq;

class FaqController extends Controller
{
    public function index(): Response
    {
        $faqs = Faq::query()
            ->orderByDesc("created_at")
            ->get();

        return inertia("Dashboard/FAQ/Index", [
            "faqs" => $faqs,
            "total" => Faq::query()->count(),
            "lastUpdate" => Faq::query()->orderByDesc("updated_at")->first()?->updated_at->diffForHumans(),
        ]);
    }

    public function create(): Response
    {
        return inertia("Dashboard/FAQ/Create");
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        Faq::query()->create($request->validated());

        return redirect()
            ->route("faqs.index")
            ->with("success", "Dodano FAQ");
    }

    public function edit(Faq $faq): Response
    {
        return inertia("Dashboard/FAQ/Edit", [
            "faq" => $faq,
        ]);
    }

    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $faq->update($request->validated());

        return redirect()
            ->route("faqs.index")
            ->with("success", "Zaktualizowano FAQ");
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->back()
            ->with("success", "Usunięto FAQ");
    }
}
