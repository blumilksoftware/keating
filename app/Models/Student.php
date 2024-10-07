<?php

declare(strict_types=1);

namespace Keating\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $first_name
 * @property string $surname
 * @property string $index_number
 * @property-read string $fullName
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Student extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "first_name",
        "surname",
        "index_number",
    ];

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn(): string => $this->first_name . " " . $this->surname,
        );
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, "student_group");
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}
