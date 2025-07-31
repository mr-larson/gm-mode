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
        Schema::table('game_session_brand', function (Blueprint $table) {
            $table->boolean('is_draft_complete')->default(false);
            $table->unsignedInteger('total_picks')->default(0);
            $table->unsignedBigInteger('budget_spent')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('game_session_brand', function (Blueprint $table) {
            $table->dropColumn(['is_draft_complete', 'total_picks', 'budget_spent']);
        });
    }

};
