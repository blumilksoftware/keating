<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Keating\Models\Faq;
use Keating\Models\User;
use Tests\TestCase;

class FaqTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testFaqCanBeCreated(): void
    {
        $this->assertDatabaseCount("faqs", 0);

        $this->post("/dashboard/faqs", [
            "question" => "Example question ?",
            "answer" => "Content of the wiki",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount("faqs", 1);
    }

    public function testFaqCanBeUpdated(): void
    {
        $faq = Faq::factory()->create();

        $this->assertDatabaseMissing("faqs", [
            "question" => "Example question ?",
            "answer" => "Content of the wiki",
        ]);

        $this->patch("/dashboard/faqs/{$faq->id}", [
            "question" => "Example question ?",
            "answer" => "Content of the wiki",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("faqs", [
            "question" => "Example question ?",
            "answer" => "Content of the wiki",
        ]);
    }

    public function testSemesterCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/faqs", [
            "question" => Str::random(256),
        ])->assertSessionHasErrors([
            "question",
        ]);

        $this->assertDatabaseCount("faqs", 0);
    }

    public function testSemesterCannotBeCreatedWithoutData(): void
    {
        $this->post("/dashboard/faqs", [])->assertSessionHasErrors([
            "question",
            "answer",
        ]);

        $this->assertDatabaseCount("faqs", 0);
    }

    public function testFaqCanBeDeleted(): void
    {
        $faq = Faq::factory()->create();
        $this->assertDatabaseCount("faqs", 1);

        $this->delete("/dashboard/faqs/$faq->id");

        $this->assertDatabaseCount("faqs", 0);
    }
}
