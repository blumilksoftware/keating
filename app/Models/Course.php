<?php

declare(strict_types=1);

namespace Keating\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Keating\Enums\ClassType;
use Keating\Observers\CourseObserver;
use Stevebauman\Purify\Facades\Purify;

/**
 * @property string $id
 * @property string $name
 * @property string $abbreviation
 * @property string $description
 * @property int $semester
 * @property string $type
 * @property string $type_abbreviation
 * @property string $form
 * @property string $field_id
 * @property Field $field
 * @property string $slug
 * @property string $semester_name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
#[ObservedBy(CourseObserver::class)]
class Course extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "name",
        "abbreviation",
        "description",
        "semester",
        "semester_name",
        "type",
        "form",
        "field_id",
        "slug",
    ];

    public function getRomanizedSemester(): string
    {
        return match ($this->semester) {
            1 => __("I"),
            2 => __("II"),
            3 => __("III"),
            4 => __("IV"),
            5 => __("V"),
            6 => __("VI"),
            7 => __("VII"),
            8 => __("VIII"),
            9 => __("IX"),
            default => __("X"),
        };
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    protected function typeAbbreviation(): Attribute
    {
        return Attribute::make(
            get: fn(): string => ClassType::from($this->type)->abbreviationLabel(),
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value): string => Purify::clean($value),
        );
    }
}
