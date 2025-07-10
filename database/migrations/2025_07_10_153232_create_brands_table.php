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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner')->nullable();
            $table->string('booker')->nullable();
            $table->string('based_in')->nullable();
            $table->string('country')->nullable();
            $table->unsignedInteger('money')->nullable();
            $table->string('style')->nullable();        // Hardcore, technique, spectacle...
            $table->string('color')->nullable();        // Pour styliser l’interface
            $table->unsignedInteger('popularity')->nullable();
            $table->date('founded')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();        // Logo ou bannière

            $table->foreignIdFor(\App\Models\User::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();                // L'utilisateur "propriétaire" de la brand

            $table->foreignId('created_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('deleted_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
