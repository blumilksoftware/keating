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
 * @property int $priority
 * @property bool $active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class GradeColumn extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "name",
        "priority",
        "active",
    ];
    protected $casts = [
        "active" => "boolean",
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}
