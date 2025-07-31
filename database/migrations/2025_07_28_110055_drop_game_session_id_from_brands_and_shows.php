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
            $table->dropForeign(['game_session_id']);
            $table->dropColumn('game_session_id');
        });
        Schema::table('shows', function (Blueprint $table) {
            $table->dropForeign(['game_session_id']);
            $table->dropColumn('game_session_id');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->foreignId('game_session_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });
        Schema::table('shows', function (Blueprint $table) {
            $table->foreignId('game_session_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });
    }
};
