<?php

declare(strict_types=1);

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\LoginController;
use App\Http\Controllers\Public\LogoutController;
use Illuminate\Support\Facades\Route;

Route::get("/", HomeController::class)->name("main");

Route::middleware("guest")->group(function (): void {
    Route::get("/login", [LoginController::class, "create"])->name("login");
    Route::post("/login", [LoginController::class, "store"]);
});

Route::middleware("auth")->group(function (): void {
    Route::get("/dashboard", DashboardController::class)->name("dashboard");
    Route::post("/logout", LogoutController::class);
});
