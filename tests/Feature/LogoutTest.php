<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Keating\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCannotLogoutIfIsGuest(): void
    {
        $this->post("/dashboard/logout")
            ->assertRedirectToRoute("login");
    }

    public function testUserCanLogout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->assertAuthenticatedAs($user);

        $this->post("/dashboard/logout")
            ->assertRedirectToRoute("main");

        $this->assertGuest();
    }
}
