<?php

declare(strict_types=1);

namespace Keating\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Facades\Purify;

/**
 * @property string $id
 * @property string $name
 * @property string $abbreviation
 * @property string $description
 * @property int $semester
 * @property string $type
 * @property string $form
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Course extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "name",
        "abbreviation",
        "description",
        "semester",
        "type",
        "form",
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

    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value): string => Purify::clean($value),
        );
    }
}
