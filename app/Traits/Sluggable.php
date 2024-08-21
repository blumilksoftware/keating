<?php

declare(strict_types=1);

namespace App\Traits;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Sluggable
{
    public function createSlug(Model $model, Closure $createStringForSlug): string
    {
        if ($model->slug) {
            return $model->slug;
        }

        $slug = Str::slug($createStringForSlug());

        if (!$this->checkIfSlugExists($model, $slug)) {
            return $slug;
        }

        $i = 2;

        while (true) {
            $newSlug = Str::slug($slug . " " . $i);

            if (!$this->checkIfSlugExists($model, $newSlug)) {
                return $newSlug;
            }

            $i++;
        }
    }

    protected function checkIfSlugExists($model, string $slug): bool
    {
        return $model::query()->where("slug", $slug)->count() > 0;
    }
}
