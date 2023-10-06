<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $id
 * @property string $name
 * @property string $course_semester_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Group extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "name",
        "course_semester_id",
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(CourseSemester::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, "student_group");
    }
}
