<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

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
            ->route("faq.index")
            ->with("success", "Zaktualizowano FAQ");
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->back()
            ->with("success", "Usunięto FAQ");
    }
}
