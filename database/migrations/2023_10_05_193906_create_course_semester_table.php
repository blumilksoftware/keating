<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("course_semester", function (Blueprint $table): void {
            $table->ulid("id")->primary();
            $table->string("course_id")->nullable();
            $table->foreign("course_id")->references("id")->on("courses")->onDelete("set null");
            $table->string("semester_id")->nullable();
            $table->foreign("semester_id")->references("id")->on("semesters")->onDelete("set null");
            $table->string("form");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("course_semester");
    }
};
