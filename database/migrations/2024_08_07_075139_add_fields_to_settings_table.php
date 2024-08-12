<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table("settings", function (Blueprint $table): void {
            $table->string("primary_color")->nullable();
            $table->string("secondary_color")->nullable();
            $table->string("logo")->nullable();
        });
    }

    public function down(): void
    {
        Schema::table("settings", function (Blueprint $table): void {
            $table->dropColumn("primary_color");
            $table->dropColumn("secondary_color");
            $table->dropColumn("logo");
        });
    }
};
