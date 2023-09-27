<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table("students", function (Blueprint $table): void {
            $table->renameColumn("name", "first_name");
        });
    }

    public function down(): void
    {
        Schema::table("students", function (Blueprint $table): void {
            $table->renameColumn("first_name", "name");
        });
    }
};
