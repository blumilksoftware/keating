<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("semesters", function (Blueprint $table): void {
            $table->ulid("id")->primary();
            $table->string("name");
            $table->enum("status", [1, 0])->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("semesters");
    }
};
