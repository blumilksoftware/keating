<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SemesterStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property SemesterStatus $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Semester extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "name",
        "status",
    ];
    protected $casts = [
        "status" => SemesterStatus::class,
    ];
}
