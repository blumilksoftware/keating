<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testNewsCanBeCreated(): void
    {
        $this->assertDatabaseCount("news", 0);

        $this->post("/dashboard/news", [
            "title" => "Example question",
            "slug" => "example-question",
            "content" => "Content of the wiki",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount("news", 1);
    }

    public function testSlugForNewsCanBeProvided(): void
    {
        $this->assertDatabaseCount("news", 0);

        $this->post("/dashboard/news", [
            "title" => "Example question",
            "slug" => "example-question",
            "content" => "Content of the wiki",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount("news", 1);

        $this->assertDatabaseHas("news", [
            "title" => "Example question",
            "slug" => "example-question",
            "content" => "Content of the wiki",
        ]);
    }

    public function testSlugForNewsCanBeGenerated(): void
    {
        $this->assertDatabaseCount("news", 0);

        $this->post("/dashboard/news", [
            "title" => "Example question",
            "content" => "Content of the wiki",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseCount("news", 1);

        $this->assertDatabaseHas("news", [
            "title" => "Example question",
            "slug" => "example-question",
            "content" => "Content of the wiki",
        ]);
    }

    public function testNewsCanBeUpdated(): void
    {
        $news = News::factory()->create();

        $this->assertDatabaseMissing("news", [
            "title" => "Example question",
            "slug" => "example-question",
            "content" => "Content of the wiki",
        ]);

        $this->patch("/dashboard/news/{$news->id}", [
            "title" => "Example question new",
            "slug" => "example-question-new",
            "content" => "Content of the wiki",
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas("news", [
            "title" => "Example question new",
            "slug" => "example-question-new",
            "content" => "Content of the wiki",
        ]);
    }

    public function testNewsCannotBeCreatedWithInvalidData(): void
    {
        $this->post("/dashboard/news", [
            "title" => Str::random(256),
        ])->assertSessionHasErrors([
            "title",
        ]);

        $this->assertDatabaseCount("news", 0);
    }

    public function testNewsCannotBeCreatedWithoutData(): void
    {
        $this->post("/dashboard/news", [
        ])->assertSessionHasErrors([
            "title",
            "content",
        ]);

        $this->assertDatabaseCount("news", 0);
    }

    public function testNewsCanBeDeleted(): void
    {
        $news = News::factory()->create();

        $this->assertDatabaseCount("news", 1);

        $this->delete("/dashboard/news/$news->id");

        $this->assertDatabaseCount("news", 0);
    }
}
