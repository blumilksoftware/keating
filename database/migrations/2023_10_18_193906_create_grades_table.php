<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("grades", function (Blueprint $table): void {
            $table->ulid("id")->primary();
            $table->boolean("status")->nullable();
            $table->string("value")->nullable();
            $table->string("student_id")->nullable();
            $table->foreign("student_id")->references("id")->on("students")->onDelete("SET NULL");
            $table->string("grade_column_id")->nullable();
            $table->foreign("grade_column_id")->references("id")->on("grade_columns")->onDelete("SET NULL");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("grades");
    }
};
