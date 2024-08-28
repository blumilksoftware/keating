<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Keating\Models\ContactInfo;
use Keating\Models\User;
use Tests\TestCase;

class ContactInfoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testContactInfoCanBeCreated(): void
    {
        $this->assertDatabaseCount("contact_infos", 0);

        $this->post("/dashboard/contact-infos", [
            "label" => "karol.zygadlo@collegiumwitelona.pl",
            "identifier" => "mailto:karol.zygadlo@collegiumwitelona.pl",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount("contact_infos", 1);
    }

    public function testContactInfoCanBeUpdated(): void
    {
        $contactInfo = ContactInfo::factory()->create();

        $this->assertDatabaseMissing("contact_infos", [
            "label" => "karol.zygadlo@collegiumwitelona.pl",
            "identifier" => "mailto:karol.zygadlo@collegiumwitelona.pl",
        ]);

        $this->patch("/dashboard/contact-infos/{$contactInfo->id}", [
            "label" => "karol.zygadlo@collegiumwitelona.pl",
            "identifier" => "mailto:karol.zygadlo@collegiumwitelona.pl",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("contact_infos", [
            "label" => "karol.zygadlo@collegiumwitelona.pl",
            "identifier" => "mailto:karol.zygadlo@collegiumwitelona.pl",
        ]);
    }

    public function testContactInfoCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/contact-infos", [
            "label" => Str::random(256),
            "identifier" => Str::random(256),
        ])->assertSessionHasErrors([
            "label",
            "identifier",
        ]);

        $this->assertDatabaseCount("contact_infos", 0);
    }

    public function testContactInfoCannotBeCreatedWithoutData(): void
    {
        $this->post("/dashboard/contact-infos", [])->assertSessionHasErrors([
            "label",
            "identifier",
        ]);

        $this->assertDatabaseCount("contact_infos", 0);
    }

    public function testContactInfoCanBeDeleted(): void
    {
        $contactInfo = ContactInfo::factory()->create();
        $this->assertDatabaseCount("contact_infos", 1);

        $this->delete("/dashboard/contact-infos/$contactInfo->id");

        $this->assertDatabaseCount("contact_infos", 0);
    }
}
