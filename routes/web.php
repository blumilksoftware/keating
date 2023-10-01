<?php

declare(strict_types=1);

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\FaqController;
use App\Http\Controllers\Dashboard\FieldController;
use App\Http\Controllers\Dashboard\LogoutController;
use App\Http\Controllers\Dashboard\PasswordUpdateController;
use App\Http\Controllers\Dashboard\SemesterController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\LoginController;
use App\Http\Controllers\Public\NewsController;
use Illuminate\Support\Facades\Route;

Route::get("/", HomeController::class)->name("main");
Route::get("/aktualnosci", NewsController::class);

Route::middleware("guest")->group(function (): void {
    Route::get("/login", [LoginController::class, "create"])->name("login");
    Route::post("/login", [LoginController::class, "store"]);
});

Route::middleware("auth")->prefix("dashboard")->group(function (): void {
    Route::get("/", DashboardController::class)->name("dashboard");
    Route::get("/password", [PasswordUpdateController::class, "edit"])->name("password.edit");
    Route::patch("/password", [PasswordUpdateController::class, "update"])->name("password.update");
    Route::post("/logout", LogoutController::class);
    Route::controller(StudentController::class)->group(function (): void {
        Route::get("/students", "index")->name("students.index");
        Route::get("/students/create", "create")->name("students.create");
        Route::post("/students", "store")->name("students.store");
        Route::get("/students/{student}/edit", "edit")->name("students.edit");
        Route::patch("/students/{student}", "update")->name("students.update");
        Route::delete("/students/{student}", "destroy")->name("students.destroy");
    });
    Route::controller(SemesterController::class)->group(function (): void {
        Route::get("/semesters", "index")->name("semesters.index");
        Route::get("/semesters/create", "create")->name("semesters.create");
        Route::post("/semesters", "store")->name("semesters.store");
        Route::get("/semesters/{semester}/edit", "edit")->name("semesters.edit");
        Route::patch("/semesters/{semester}", "update")->name("semesters.update");
        Route::delete("/semesters/{semester}", "destroy")->name("semesters.destroy");
        Route::post("/semesters/{semester}/activate", "toggleActive")->name("semesters.toggle.active");
    });
    Route::controller(FieldController::class)->group(function (): void {
        Route::get("/fields", "index")->name("fields.index");
        Route::get("/fields/create", "create")->name("fields.create");
        Route::post("/fields", "store")->name("fields.store");
        Route::get("/fields/{field}/edit", "edit")->name("fields.edit");
        Route::patch("/fields/{field}", "update")->name("fields.update");
        Route::delete("/fields/{field}", "destroy")->name("fields.destroy");
    });
    Route::controller(FaqController::class)->group(function (): void {
        Route::get("/faqs", "index")->name("faqs.index");
        Route::get("/faqs/create", "create")->name("faqs.create");
        Route::post("/faqs", "store")->name("faqs.store");
        Route::get("/faqs/{faq}/edit", "edit")->name("faqs.edit");
        Route::patch("/faqs/{faq}", "update")->name("faqs.update");
        Route::delete("/faqs/{faq}", "destroy")->name("faqs.destroy");
    });
});
