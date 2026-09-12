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
        Schema::create('visions_missions', function (Blueprint $table) {
            $table->id();
            $table->string('type');                     // "vision" or "mission"
            $table->string('heading');                  // e.g., "OUR VISION"
            $table->text('content');
            $table->string('icon');                     // e.g., "fas fa-eye"
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
        Schema::dropIfExists('visions_missions');
    }
};
