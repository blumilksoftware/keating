<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table("courses", function (Blueprint $table): void {
            $table->string("field_id")->nullable();
            $table->foreign("field_id")->references("id")->on("fields")->onDelete("CASCADE");
        });
    }

    public function down(): void
    {
        Schema::table("courses", function (Blueprint $table): void {
            $table->dropColumn("field_id");
        });
    }
};
