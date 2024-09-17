<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table("settings", function (Blueprint $table): void {
            $table->string("schedule_link")->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::table("settings", function (Blueprint $table): void {
            $table->dropColumn("schedule_link");
        });
    }
};
