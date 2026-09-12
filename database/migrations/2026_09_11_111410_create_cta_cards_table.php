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
        Schema::create('cta_cards', function (Blueprint $table) {
            $table->id();
            $table->string('title');                    // e.g., "VOLUNTEER"
            $table->text('description');
            $table->string('icon');                     // e.g., "fas fa-hands-helping"
            $table->string('button_text');              // e.g., "BECOME A VOLUNTEER"
            $table->string('button_link');              // e.g., "/volunteer"
            $table->string('image')->nullable();
            $table->string('color_theme')->default('green'); // green or gold
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cta_cards');
    }
};
