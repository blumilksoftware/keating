<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("courses", function (Blueprint $table): void {
            $table->ulid("id")->primary();
            $table->string("abbreviation");
            $table->string("name");
            $table->longText("description");
            $table->integer("semester");
            $table->string("type");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("courses");
    }
};
