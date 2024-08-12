<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Inertia\Response;

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
