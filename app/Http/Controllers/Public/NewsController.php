<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Inertia\Response;

class NewsController extends Controller
{
    public function __invoke(): Response
    {
        return inertia("Public/News", [
            "title" => "mgr inż.",
        ]);
    }
}
