<?php

declare(strict_types=1);

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController;
use Illuminate\Support\Facades\Route;

Route::get("/", HomeController::class);
Route::get("/aktualnosci", NewsController::class);

Route::get("/dashboard", DashboardController::class);
