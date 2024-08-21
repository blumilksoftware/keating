<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\News;
use App\Traits\Sluggable;

class NewsObserver
{
    use Sluggable;

    public function creating(News $news): void
    {
        $news->slug = $this->createSlug($news, "title", $news->published_at->format("Y-m-d"));
    }
}
