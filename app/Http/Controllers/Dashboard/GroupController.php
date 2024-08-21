<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Dashboard;

use Illuminate\Http\RedirectResponse;
use Keating\Http\Requests\GroupRequest;
use Keating\Models\CourseSemester;
use Keating\Models\Group;

class GroupController
{
    public function store(GroupRequest $request, CourseSemester $course): RedirectResponse
    {
        $course->groups()->create($request->validated());

        return redirect()->back()
            ->with("success", "Dodano grupę");
    }

    public function update(GroupRequest $request, CourseSemester $course, Group $group): RedirectResponse
    {
        $group->update($request->validated());

        return redirect()->back()
            ->with("success", "Zaktualizowano grupę");
    }

    public function destroy(CourseSemester $course, Group $group): RedirectResponse
    {
        $group->students()->detach($group->students);
        $group->delete();

        return redirect()->back()
            ->with("success", "Usunięto grupę");
    }
}
