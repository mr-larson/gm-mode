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
        Schema::table('brands', function (Blueprint $table) {
            $table->foreignId('game_session_id')->nullable()->constrained()->cascadeOnDelete();
        });

        Schema::table('shows', function (Blueprint $table) {
            $table->foreignId('game_session_id')->nullable()->constrained()->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands_and_shows', function (Blueprint $table) {
            //
        });
    }
};
