<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use JsonException;
use Keating\Models\User;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory([
            "email" => "test@example.com",
            "password" => Hash::make("password"),
        ])->create();
    }

    /**
     * @throws JsonException
     */
    public function testUserPasswordCanBeUpdated(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->patch("/dashboard/password", [
                "current_password" => "password",
                "password" => "new-password",
                "password_confirmation" => "new-password",
            ]);

        $response->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check("new-password", $this->user->refresh()->password));
    }

    public function testUserPasswordCannotBeUpdatedWithWrongPassword(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->patch("/dashboard/password", [
                "current_password" => "wrong-password",
                "password" => "new-password",
                "password_confirmation" => "new-password",
            ]);

        $response->assertSessionHasErrors("current_password");
    }
}
