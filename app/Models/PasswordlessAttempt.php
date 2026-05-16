<?php

declare(strict_types=1);

namespace Keating\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $email
 * @property string $session_id
 * @property bool $can_login
 * @property Carbon $expires_at
 */
class PasswordlessAttempt extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "email",
        "session_id",
        "can_login",
        "expires_at",
    ];
}
