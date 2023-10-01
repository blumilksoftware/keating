<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(Request $request): Response
    {
        $searchText = $request->query("search");
        $news = News::query()
            ->when(
                $searchText !== null,
                fn(Builder $query): Builder => $query
                    ->where("title", "ILIKE", "%$searchText%")
            )
            ->paginate()
            ->withQueryString();

        return inertia("Dashboard/News/Index", [
            "news" => $news,
            "total" => News::query()->count(),
            "lastUpdate" => News::query()->orderByDesc("updated_at")->first()?->updated_at->diffForHumans(),
        ]);
    }

    public function create(): Response
    {
        return inertia("Dashboard/News/Create");
    }

    public function store(NewsRequest $request): RedirectResponse
    {
        News::query()->create($request->getData());

        return redirect()
            ->route("news.index")
            ->with("success", "Dodano wpis");
    }

    public function edit(News $news): Response
    {
        return inertia("Dashboard/News/Edit", [
            "news" => $news,
        ]);
    }

    public function update(NewsRequest $request, News $news): RedirectResponse
    {
        $news->update($request->getData());

        return redirect()
            ->route("news.index")
            ->with("success", "Zaktualizowano wpis");
    }

    public function destroy(News $news): RedirectResponse
    {
        $news->delete();

        return redirect()->back()
            ->with("success", "Usunięto wpis");
    }
}
