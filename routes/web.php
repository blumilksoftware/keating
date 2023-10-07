<?php

declare(strict_types=1);

use App\Http\Controllers\Dashboard\ContactInfoController;
use App\Http\Controllers\Dashboard\CourseController;
use App\Http\Controllers\Dashboard\CourseSemesterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\FieldController;
use App\Http\Controllers\Dashboard\GroupController;
use App\Http\Controllers\Dashboard\GroupStudentController;
use App\Http\Controllers\Dashboard\LogoutController;
use App\Http\Controllers\Dashboard\PasswordUpdateController;
use App\Http\Controllers\Dashboard\SemesterController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\FaqController;
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
    Route::post("/logout", LogoutController::class);
    Route::get("/password", [PasswordUpdateController::class, "edit"])->name("password.edit");
    Route::patch("/password", [PasswordUpdateController::class, "update"])->name("password.update");
    Route::controller(ContactInfoController::class)->group(function (): void {
        Route::get("/contact-infos", "index")->name("contactInfo.index");
        Route::get("/contact-infos/create", "create")->name("contactInfo.create");
        Route::post("/contact-infos", "store")->name("contactInfo.store");
        Route::get("/contact-infos/{contact_info}/edit", "edit")->name("contactInfo.edit");
        Route::patch("/contact-infos/{contact_info}", "update")->name("contactInfo.update");
        Route::delete("/contact-infos/{contact_info}", "destroy")->name("contactInfo.destroy");
    });
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
    Route::controller(CourseController::class)->group(function (): void {
        Route::get("/courses", "index")->name("courses.index");
        Route::get("/courses/create", "create")->name("courses.create");
        Route::post("/courses", "store")->name("courses.store");
        Route::get("/courses/{course}/edit", "edit")->name("courses.edit");
        Route::patch("/courses/{course}", "update")->name("courses.update");
        Route::delete("/courses/{course}", "destroy")->name("courses.destroy");
    });
    Route::controller(CourseSemesterController::class)->group(function (): void {
        Route::get("/course-semester", "index")->name("course.semester.index");
        Route::get("/course-semester/create", "create")->name("course.semester.create");
        Route::post("/course-semester", "store")->name("course.semester.store");
        Route::get("/course-semester/{course}", "show")->name("course.semester.show");
        Route::get("/course-semester/{course}/edit", "edit")->name("course.semester.edit");
        Route::patch("/course-semester/{course}", "update")->name("course.semester.update");
        Route::delete("/course-semester/{course}", "destroy")->name("course.semester.destroy");
    });
    Route::controller(GroupController::class)->group(function (): void {
        Route::post("/course-semester/{course}/groups", "store")->name("course.semester.group.store");
        Route::patch("/course-semester/{course}/groups/{group}", "update")->name("course.semester.group.update");
        Route::delete("/course-semester/{course}/groups/{group}", "destroy")->name("course.semester.group.destroy");
    });
    Route::controller(GroupStudentController::class)->group(function (): void {
        Route::get("/course-semester/{course}/groups/{group}/students", "index")->name("course.semester.group.students.index");
        Route::post("/course-semester/{course}/groups/{group}/students", "store")->name("course.semester.group.students.store");
        Route::delete("/course-semester/{course}/groups/{group}/students/{student}", "destroy")->name("course.semester.group.students.destroy");
    });
});
