<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\News;
use App\Traits\Sluggable;
use Illuminate\Support\Str;

class NewsObserver
{
    use Sluggable;

    public function creating(News $news): void
    {
        $news->slug = $this->createSlug($news, "title");
    }

    protected function buildBaseSlug(News $model, string $attribute): string
    {
        return Str::slug($model->published_at->format("Y-m-d") . " " . $model->{$attribute});
    }
}
