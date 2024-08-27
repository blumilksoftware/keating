<?php

declare(strict_types=1);

namespace Keating\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Keating\Enums\Icons;

/**
 * @property string $id
 * @property string $label
 * @property string $identifier
 * @property Icons $icon
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ContactInfo extends Model
{
    use HasFactory;
    use HasUlids;

    protected $guarded = [];
}
