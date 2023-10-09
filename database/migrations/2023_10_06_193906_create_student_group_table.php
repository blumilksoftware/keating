<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("student_group", function (Blueprint $table): void {
            $table->string("group_id")->nullable();
            $table->foreign("group_id")->references("id")->on("groups")->onDelete("set null");
            $table->string("student_id")->nullable();
            $table->foreign("student_id")->references("id")->on("students")->onDelete("set null");
            $table->primary(["student_id", "group_id"], "student_group_id_primary");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("student_group");
    }
};
