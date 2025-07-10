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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();

            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('nickname')->nullable();
            $table->string('gender')->nullable();
            $table->unsignedInteger('age')->nullable();

            $table->string('style')->nullable();      // Brawler, High-Flyer, etc.
            $table->string('status')->nullable();     // Actif, blessé, suspendu...
            $table->string('category')->nullable();   // Main event, midcard, etc.
            $table->string('alignment')->nullable();  // Face, Heel

            $table->unsignedInteger('height')->nullable();  // cm
            $table->unsignedInteger('weight')->nullable();  // kg

            $table->string('image')->nullable();      // Portrait

            // Statistiques
            $table->unsignedInteger('overall')->default(0);
            $table->unsignedInteger('popularity')->default(0);
            $table->unsignedInteger('endurance')->default(0);
            $table->unsignedInteger('promo_skill')->default(0);

            // Palmarès
            $table->unsignedInteger('wins')->default(0);
            $table->unsignedInteger('draws')->default(0);
            $table->unsignedInteger('losses')->default(0);

            $table->text('note')->nullable();

            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');

            // Relations avec les utilisateurs
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
