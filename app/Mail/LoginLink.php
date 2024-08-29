<?php

declare(strict_types=1);

namespace Keating\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class LoginLink extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly string $url,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Magic Link is here!",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: "emails.auth.login-link",
            with: [
                "url" => $this->url,
            ],
        );
    }
}