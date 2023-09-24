<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("contact_infos", function (Blueprint $table): void {
            $table->ulid("id")->primary();
            $table->string("email");
            $table->string("github_handle")->nullable();
            $table->string("alternative_channel")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("contact_infos");
    }
};
