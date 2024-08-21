<?php

declare(strict_types=1);

namespace Keating\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Keating\Observers\NewsObserver;

/**
 * @property string $id
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property Carbon $published_at
 */
#[ObservedBy(NewsObserver::class)]
class News extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        "slug",
        "title",
        "content",
        "published_at",
    ];
    protected $casts = [
        "published_at" => "datetime:Y-m-d H:i",
    ];
    protected $Keatingends = [
        "published_at_formatted",
    ];

    protected function getPublishedAtFormattedAttribute(): string
    {
        return $this->published_at->isoFormat("LL");
    }
}
