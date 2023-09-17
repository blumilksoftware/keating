<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCannotLogoutIfIsGuest(): void
    {
        $this->post("/logout")
            ->assertRedirectToRoute("login");
    }

    public function testUserCanLogout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->assertAuthenticatedAs($user);

        $this->post("/logout")
            ->assertRedirectToRoute("main");

        $this->assertGuest();
    }
}
