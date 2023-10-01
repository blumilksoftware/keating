<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("faqs", function (Blueprint $table): void {
            $table->ulid("id")->primary();
            $table->string("question");
            $table->longText("answer");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("faqs");
    }
};
