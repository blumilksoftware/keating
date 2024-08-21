<?php

declare(strict_types=1);

namespace Tests\Feature;

use Keating\Models\SectionSettings;
use Keating\Models\Setting;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function tearDown(): void
    {
        Setting::query()->delete();

        parent::tearDown();
    }

    public function testTheApplicationReturnsASuccessfulResponse(): void
    {
        Setting::factory()->create();
        SectionSettings::factory()->create();

        $response = $this->get("/");

        $response->assertStatus(200);
    }
}
