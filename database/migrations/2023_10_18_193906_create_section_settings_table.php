<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("section_settings", function (Blueprint $table): void {
            $table->ulid("id")->primary();
            $table->boolean("banner_enabled");
            $table->boolean("about_enabled");
            $table->boolean("counters_enabled");
            $table->boolean("contact_enabled");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("section_settings");
    }
};
