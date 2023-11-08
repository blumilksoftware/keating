<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property bool $banner_enabled
 * @property bool $about_enabled
 * @property bool $counters_enabled
 * @property bool $contact_enabled
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SectionSettings extends Model
{
    use HasUlids;

    protected $fillable = [
        "banner_enabled",
        "about_enabled",
        "counters_enabled",
        "contact_enabled",
    ];
    protected $casts = [
        "banner_enabled" => "boolean",
        "about_enabled" => "boolean",
        "counters_enabled" => "boolean",
        "contact_enabled" => "boolean",
    ];
}
