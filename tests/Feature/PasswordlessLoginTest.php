<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Keating\Mail\LoginLink;
use Keating\Models\User;
use Tests\TestCase;

class PasswordlessLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        User::factory(["email" => "test@example.com"])->create();
    }

    public function testUserCanPasswordLessLogin(): void
    {
        $this->assertDatabaseMissing("passwordless_attempts", [
            "email" => "test@example.com",
        ]);

        $this->post("/passwordless", [
            "email" => "test@example.com",
        ])->assertRedirect("/passwordless");

        Mail::assertSentCount(1);
        $link = Mail::sent(LoginLink::class)->first()->url;

        $this->assertDatabaseHas("passwordless_attempts", [
            "email" => "test@example.com",
            "can_login" => false,
        ]);

        $this->get($link)->assertRedirect("/passwordless");

        $this->assertDatabaseHas("passwordless_attempts", [
            "email" => "test@example.com",
            "can_login" => true,
        ]);
    }

    public function testUserCannotLoginWithExpiredLink(): void
    {
        $this->assertDatabaseMissing("passwordless_attempts", [
            "email" => "test@example.com",
        ]);

        $this->post("/passwordless", [
            "email" => "test@example.com",
        ])->assertRedirect("/passwordless");

        Mail::assertSentCount(1);
        $link = Mail::sent(LoginLink::class)->first()->url;

        $this->travel(6)->minutes();

        $this->assertDatabaseHas("passwordless_attempts", [
            "email" => "test@example.com",
            "can_login" => false,
        ]);

        $this->get($link)->assertStatus(401);

        $this->assertDatabaseHas("passwordless_attempts", [
            "email" => "test@example.com",
            "can_login" => false,
        ]);
    }
}
