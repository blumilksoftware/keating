<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("passwordless_attempts", function (Blueprint $table): void {
            $table->ulid("id")->primary();
            $table->string("email")->unique();
            $table->string("session_id");
            $table->boolean("can_login")->default(false);
            $table->timestamp("expires_at");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("passwordless_attempts");
    }
};
