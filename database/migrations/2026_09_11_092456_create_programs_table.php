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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');                    // e.g., "Education & Lifelong Learning"
            $table->string('slug')->unique();           // e.g., "education-lifelong-learning"
            $table->text('short_description');          // Card description
            $table->longText('full_description')->nullable(); // Full page description
            $table->string('icon');                     // e.g., "fas fa-graduation-cap"
            $table->string('image')->nullable();        // Feature image
            $table->integer('order')->default(0);       // Display order
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
