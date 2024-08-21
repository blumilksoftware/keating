<?php

declare(strict_types=1);

namespace Keating\Observers;

use Keating\Models\Course;
use Keating\Traits\Sluggable;

class CourseObserver
{
    use Sluggable;

    public function creating(Course $course): void
    {
        $course->slug = $this->createSlug($course, fn(): string => $course->name);
    }
}
