<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
