<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("settings", function (Blueprint $table): void {
            $table->ulid("id")->primary();
            $table->string("teacher_name")->nullable();
            $table->string("teacher_email")->nullable();
            $table->string("teacher_titles")->nullable();
            $table->string("university_name")->nullable();
            $table->string("department_name")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("settings");
    }
};
