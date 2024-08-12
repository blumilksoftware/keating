<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

/**
 * @property string $id
 * @property string $name
 * @property boolean $active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Semester extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "name",
        "active",
    ];
    protected $casts = [
        "active" => "boolean",
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where("active", true);
    }

    /**
     * @return ?Semester
     */
    public static function getActive(): ?Model
    {
        return self::active()->first();
    }

    public function courses(): HasMany
    {
        return $this->hasMany(CourseSemester::class);
    }

    public function groups(): HasManyThrough
    {
        return $this->hasManyThrough(Group::class, CourseSemester::class);
    }

    public function students(): Collection
    {
        return $this->groups()
            ->get()
            ->map(fn(Group $group): Collection => $group->students)
            ->flatten()
            ->unique("id");
    }
}
