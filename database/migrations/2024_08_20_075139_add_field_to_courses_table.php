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
            $table->string("slug");
            $table->string("semester_name");
        });
    }

    public function down(): void
    {
        Schema::table("courses", function (Blueprint $table): void {
            $table->dropColumn("field_id");
            $table->dropColumn("slug");
            $table->dropColumn("semester_name");
        });
    }
};
