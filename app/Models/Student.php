<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $id
 * @property string $first_name
 * @property string $surname
 * @property string $index_number
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

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, "student_group");
    }
}
