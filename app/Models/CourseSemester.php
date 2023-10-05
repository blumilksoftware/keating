<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $name
 * @property string $course_id
 * @property string $semester_id
 * @property string $form
 * @property Course $course
 * @property Semester $semester
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class CourseSemester extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = "course_semester";
    protected $fillable = [
        "name",
        "course_id",
        "semester_id",
        "form",
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
