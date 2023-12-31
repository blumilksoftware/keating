<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("groups", function (Blueprint $table): void {
            $table->ulid("id")->primary();
            $table->string("name");
            $table->string("form");
            $table->string("course_semester_id")->nullable();
            $table->foreign("course_semester_id")->references("id")->on("course_semester")->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("groups");
    }
};
