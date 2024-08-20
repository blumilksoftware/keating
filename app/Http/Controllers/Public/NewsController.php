<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Public;

use Inertia\Response;
use Keating\Http\Controllers\Controller;
use Keating\Models\News;

class NewsController extends Controller
{
    public function index(): Response
    {
        $news = News::query()
            ->orderBy("published_at", "desc")
            ->paginate(9);

        return inertia("Public/News/Index", [
            "paginator" => $news,
        ]);
    }

    public function get(string $slug): Response
    {
        $news = News::query()
            ->where("slug", $slug)
            ->sole();

        return inertia("Public/News/News", [
            "news" => $news,
        ]);
    }
}
