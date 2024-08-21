<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Course;
use Illuminate\Support\Str;

class CourseObserver
{
    public function creating(Course $course): void
    {
        if ($course->slug) {
            return;
        }

        $slug = Str::slug($course->abbreviation);

        if (!$this->checkIfSlugExists($slug)) {
            $course->slug = $slug;

            return;
        }

        $i = 2;

        while (true) {
            $newSlug = Str::slug($slug . " " . $i);

            if (!$this->checkIfSlugExists($newSlug)) {
                $course->slug = $newSlug;

                return;
            }

            $i++;
        }
    }

    protected function checkIfSlugExists(string $slug): bool
    {
        return Course::query()->where("slug", $slug)->count() > 0;
    }
}
