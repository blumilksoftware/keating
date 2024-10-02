<?php

declare(strict_types=1);

namespace Keating\Actions;

use Carbon\Carbon;
use Keating\Models\PasswordlessAttempt;

class PasswordlessCheckAndClearAttemptAction
{
    public function handle(string $email, string $sessionId): bool
    {
        $passwordlessAttempt = PasswordlessAttempt::query()
            ->where("email", $email)
            ->where("can_login", true)
            ->where("expires_at", ">", Carbon::now())
            ->where("session_id", $sessionId)
            ->first();

        if ($passwordlessAttempt === null) {
            return false;
        }

        $passwordlessAttempt->delete();

        return true;
    }
}
