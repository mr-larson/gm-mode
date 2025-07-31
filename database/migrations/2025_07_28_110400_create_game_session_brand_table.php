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
        Schema::create('game_session_brand', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_session_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('brand_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->boolean('is_human')->default(false);
            $table->integer('draft_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_session_brand');
    }
};
