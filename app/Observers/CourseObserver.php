<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Course;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CourseObserver
{
    use Sluggable;

    public function creating(Course $course): void
    {
        $course->slug = $this->createSlug($course, "name");
    }

    protected function buildBaseSlug(Model $model, string $attribute): string
    {
        return Str::slug($model->{$attribute});
    }
}
