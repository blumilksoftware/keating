<?php

declare(strict_types=1);

namespace Keating\Observers;

use Keating\Traits\Sluggable;
use Keating\Models\News;

class NewsObserver
{
    use Sluggable;

    public function creating(News $news): void
    {
        $news->slug = $this->createSlug($news, fn(): string => $news->published_at->format("Y-m-d") . " " . $news->title);
    }
}
