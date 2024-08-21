<?php

declare(strict_types=1);

namespace Keating\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Keating\Observers\SettingObserver;

/**
 * @property string $id
 * @property string $teacher_name
 * @property string $teacher_email
 * @property string $teacher_titles
 * @property string $university_name
 * @property string $department_name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
#[ObservedBy(SettingObserver::class)]
class Setting extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "teacher_name",
        "teacher_email",
        "teacher_titles",
        "university_name",
        "department_name",
        "primary_color",
        "secondary_color",
        "logo",
    ];
}
