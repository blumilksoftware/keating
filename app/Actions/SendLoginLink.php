<?php

declare(strict_types=1);

namespace Keating\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Keating\Mail\LoginLink;

final class SendLoginLink
{
    public function handle(string $email, Carbon $time): void
    {
        Mail::to(
            users: $email,
        )->send(
            mailable: new LoginLink(
                url: URL::temporarySignedRoute(
                    name: "passwordless.login",
                    expiration: (int)Carbon::now()->diffInSeconds($time),
                    parameters: [
                        "email" => $email,
                    ],
                ),
            ),
        );
    }
}
