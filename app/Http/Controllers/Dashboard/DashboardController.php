<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return inertia("Dashboard/Home", [
            "title" => "mgr inż.",
            "name" => "Krzysztof Rewak",
            "counters" => [
                [
                    ["name" => "Liczba studentów w tym semestrze", "value" => 54],
                    ["name" => "Liczba kursów w tym semestrze", "value" => 6],
                    ["name" => "Liczba grup w tym semestrze", "value" => 10],
                ],
                [
                    ["name" => "Liczba studentów", "value" => 356],
                    ["name" => "Liczba kursów", "value" => 15],
                    ["name" => "Liczba grup", "value" => 87],
                ],
            ],
        ]);
    }
}
