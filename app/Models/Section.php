<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SectionType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Facades\Purify;

/**
 * @property string $id
 * @property string $title
 * @property string $value
 * @property SectionType $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Section extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "title",
        "value",
        "type",
    ];
    protected $casts = [
        "type" => SectionType::class,
    ];

    public function scopeCounter(Builder $query): Builder
    {
        return $query->where("type", SectionType::Counter->value);
    }

    public function scopeAbout(Builder $query): Builder
    {
        return $query->where("type", SectionType::About->value);
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value): string => Purify::clean($value),
        );
    }
}
