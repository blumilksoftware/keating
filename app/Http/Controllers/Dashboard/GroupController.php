<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Models\CourseSemester;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;

class GroupController extends Controller
{
    public function store(GroupRequest $request, CourseSemester $course): RedirectResponse
    {
        $course->groups()->create(["name" => $request->get("name")]);

        return redirect()->back()
            ->with("success", "Dodano grupę");
    }

    public function update(GroupRequest $request, CourseSemester $course, Group $group): RedirectResponse
    {
        $group->update(["name" => $request->get("name")]);

        return redirect()->back()
            ->with("success", "Zaktualizowano grupę");
    }

    public function destroy(CourseSemester $course, Group $group): RedirectResponse
    {
        $group->delete();

        return redirect()->back()
            ->with("success", "Usunięto grupę");
    }
}
