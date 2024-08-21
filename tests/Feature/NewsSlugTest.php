<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Keating\Models\News;
use Tests\TestCase;

class NewsSlugTest extends TestCase
{
    use RefreshDatabase;

    public function testNewsSlugging(): void
    {
        News::factory()->create([
            "title" => "Test",
            "published_at" => "2024-06-01 15:00:00",
        ]);

        $this->assertEquals("2024-06-01-test", News::query()->first()->slug);
    }

    public function testMultipleNewsSlugging(): void
    {
        News::factory()->create([
            "title" => "Test",
            "published_at" => "2024-06-01 15:00:00",
        ]);

        News::factory()->create([
            "title" => "Test",
            "published_at" => "2024-06-15 15:00:00",
        ]);

        $news = News::query()->get();

        $this->assertEquals("2024-06-01-test", $news[0]->slug);
        $this->assertEquals("2024-06-15-test", $news[1]->slug);
    }

    public function testMultipleNewsWithRepeatedTitleSlugging(): void
    {
        News::factory()->create([
            "title" => "Test",
            "published_at" => "2024-06-01 15:00:00",
        ]);

        News::factory()->create([
            "title" => "Test",
            "published_at" => "2024-06-01 15:00:00",
        ]);

        News::factory()->create([
            "title" => "Test",
            "published_at" => "2024-06-15 15:00:00",
        ]);

        News::factory()->create([
            "title" => "Test",
            "published_at" => "2024-06-01 15:00:00",
        ]);

        $news = News::query()->get();

        $this->assertEquals("2024-06-01-test", $news[0]->slug);
        $this->assertEquals("2024-06-01-test-2", $news[1]->slug);
        $this->assertEquals("2024-06-15-test", $news[2]->slug);
        $this->assertEquals("2024-06-01-test-3", $news[3]->slug);
    }
}
