<?php

declare(strict_types=1);

namespace Keating\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Keating\Observers\GradeObserver;

/**
 * @property string $id
 * @property ?boolean $status
 * @property ?string $value
 * @property string $student_id
 * @property Student $student
 * @property string $grade_column_id
 * @property GradeColumn $gradeColumn
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Grade extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "status",
        "value",
        "student_id",
        "grade_column_id",
    ];
    protected $casts = [
        "status" => "boolean",
    ];

    public function gradeColumn(): BelongsTo
    {
        return $this->belongsTo(GradeColumn::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    protected static function booted(): void
    {
        self::observe(GradeObserver::class);
    }
}
