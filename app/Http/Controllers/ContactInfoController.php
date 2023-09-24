<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateContactInfoRequest;
use App\Models\ContactInfo;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ContactInfoController extends Controller
{
    public function edit(): Response
    {
        return inertia("Dashboard/ContactInfo", [
            "contactInfo" => ContactInfo::query()->first(),
        ]);
    }

    public function update(UpdateContactInfoRequest $request): RedirectResponse
    {
        ContactInfo::query()->first()->update($request->validated());

        return redirect()->back()
            ->with("success", "Zaktualizowano formy kontaktu");
    }
}
