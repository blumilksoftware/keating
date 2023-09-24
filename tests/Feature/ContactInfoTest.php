<?php

namespace Tests\Feature;

use App\Models\ContactInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactInfoTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected ContactInfo $contactInfo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->contactInfo = ContactInfo::factory()->create([
            "github_handle" => null,
            "alternative_channel" => null
        ]);
    }

    public function testContactInfoCanBeUpdated(): void
    {
        $this->assertDatabaseMissing("contact_infos", [
            "email" => "user@collegiumwitelona.pl",
            "github_handle" => "https://test@test.pl",
            "alternative_channel" => "https://test@test.pl",
        ]);

        $this->actingAs($this->user)->patch("/dashboard/contact-info", [
            "email" => "user@collegiumwitelona.pl",
            "github_handle" => "https://test@test.pl",
            "alternative_channel" => "https://test@test.pl",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("contact_infos", [
            "email" => "user@collegiumwitelona.pl",
            "github_handle" => "https://test@test.pl",
            "alternative_channel" => "https://test@test.pl",
        ]);
    }

    public function testContactInfoCanBeUpdatedWithOnlyEmail(): void
    {
        $this->actingAs($this->user)->patch("/dashboard/contact-info", [
            "email" => "user@collegiumwitelona.pl",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("contact_infos", [
            "email" => "user@collegiumwitelona.pl",
            "github_handle" => null,
            "alternative_channel" => null,
        ]);
    }

    public function testContactInfoCannotBeUpdatedWithoutEmail(): void
    {
        $this->actingAs($this->user)->patch("/dashboard/contact-info", [
            "email" => null,
            "github_handle" => "https://test@test.pl",
            "alternative_channel" => "https://test@test.pl",
        ])->assertSessionHasErrors("email");
    }

}
