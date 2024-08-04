<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sub_divisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id')->nullable(true);
            $table->string('name',200);
            $table->string('role')->nullable(true);
            $table->string('div')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_divisions');
    }
};
