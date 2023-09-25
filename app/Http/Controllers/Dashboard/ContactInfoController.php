<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactInfoRequest;
use App\Models\ContactInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class ContactInfoController extends Controller
{
    public function index(Request $request): Response
    {
        $searchText = $request->query("search");
        $contactInfos = ContactInfo::query()
            ->when(
                $searchText !== null,
                fn(Builder $query): Builder => $query
                    ->where("label", "ILIKE", "%$searchText%")
                    ->orWhere("link", "ILIKE", "%$searchText%")
            )
            ->paginate()
            ->withQueryString();

        return inertia("Dashboard/ContactInfo/Index", [
            "contactInfos" => $contactInfos,
            "total" => ContactInfo::query()->count(),
            "lastUpdate" => ContactInfo::query()->orderByDesc("updated_at")->first()?->updated_at->diffForHumans(),
        ]);
    }

    public function create(): Response
    {
        return inertia("Dashboard/ContactInfo/Create");
    }

    public function store(ContactInfoRequest $request): RedirectResponse
    {
        ContactInfo::query()->create($request->validated());

        return redirect()
            ->route("contactInfo.index")
            ->with("success", "Dodano formę kontaktu");
    }

    public function edit(ContactInfo $contactInfo): Response
    {
        return inertia("Dashboard/ContactInfo/Edit", [
            "contactInfo" => $contactInfo,
        ]);
    }

    public function update(ContactInfoRequest $request, ContactInfo $contactInfo): RedirectResponse
    {
        $contactInfo->update($request->validated());

        return redirect()
            ->route("contactInfo.index")
            ->with("success", "Zaktualizowano formę kontaktu");
    }

    public function destroy(ContactInfo $contactInfo): RedirectResponse
    {
        $contactInfo->delete();

        return redirect()->back()
            ->with("success", "Usunięto formę kontaktu");
    }
}
