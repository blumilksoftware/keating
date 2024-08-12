<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\News;
use Illuminate\Support\Str;

class NewsObserver
{
    public function creating(News $news): void
    {
        if ($news->slug) {
            return;
        }

        $slug = Str::slug($news->published_at->format("Y-m-d") . " " . $news->title);

        if (!$this->checkIfSlugExists($slug)) {
            $news->slug = $slug;

            return;
        }

        $i = 2;

        while (true) {
            $newSlug = Str::slug($slug . " " . $i);

            if (!$this->checkIfSlugExists($newSlug)) {
                $news->slug = $newSlug;

                return;
            }

            $i++;
        }
    }

    protected function checkIfSlugExists(string $slug): bool
    {
        return News::query()->where("slug", $slug)->count() > 0;
    }
}
