<?php

declare(strict_types=1);

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\LogoutController;
use App\Http\Controllers\Dashboard\PasswordUpdateController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\LoginController;
use App\Http\Controllers\Public\NewsController;
use Illuminate\Support\Facades\Route;

Route::get("/", HomeController::class);
Route::get("/aktualnosci", NewsController::class);

Route::middleware("guest")->group(function (): void {
    Route::get("/login", [LoginController::class, "create"])->name("login");
    Route::post("/login", [LoginController::class, "store"]);
});

Route::middleware("auth")->prefix("dashboard")->group(function (): void {
    Route::get("/", DashboardController::class)->name("dashboard");
    Route::get("/password", [PasswordUpdateController::class, "edit"])->name("password.edit");
    Route::put("/password/update", [PasswordUpdateController::class, "update"])->name("password.update");
    Route::post("/logout", LogoutController::class);
    Route::controller(StudentController::class)->group(function (): void {
        Route::get("/students", "index")->name("students.index");
        Route::get("/students/create", "create")->name("students.create");
        Route::post("/students", "store")->name("students.store");
        Route::get("/students/{student}/edit", "edit")->name("students.edit");
        Route::patch("/students/{student}", "update")->name("students.update");
        Route::delete("/students/{student}", "destroy")->name("students.destroy");
    });
});
