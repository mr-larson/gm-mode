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
        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Nom optionnel de la session (ex : "Partie 1")
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Si multi-joueurs
            $table->date('started_at'); // Date de début de la partie
            $table->unsignedInteger('week')->default(1); // Semaine actuelle
            $table->unsignedInteger('year')->default(1); // Année (si tu veux avancer dans le temps)
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable(); // Difficulté, nombre de semaines, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_sessions');
    }
};
