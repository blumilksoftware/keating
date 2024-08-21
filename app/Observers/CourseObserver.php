<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Course;
use App\Traits\Sluggable;

class CourseObserver
{
    use Sluggable;

    public function creating(Course $course): void
    {
        $course->slug = $this->createSlug($course, "name");
    }
}
