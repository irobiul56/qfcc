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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('membership_id')->nullable()->constrained('memberships')->cascadeOnDelete();
            $table->foreignId('donation_id')->nullable()->constrained('donations')->nullOnDelete();

            
            $table->string('reference')->unique();          // e.g. QFCC-TXN-20241108-0001
            $table->enum('payment_method', ['stripe', 'zelle', 'bank', 'cash']);
            $table->decimal('amount', 8, 2);
            $table->string('currency', 3)->default('USD');

            $table->enum('status', [
                'pending',      // waiting for payment
                'processing',   // payment initiated
                'completed',    // paid successfully
                'failed',       // payment failed
                'refunded',     // refunded
                'cancelled',
            ])->default('pending');

            // Stripe-specific fields
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_charge_id')->nullable();
            $table->string('card_last4', 4)->nullable();
            $table->string('card_brand')->nullable();

            // Zelle-specific fields
            $table->string('zelle_reference')->nullable();
            $table->string('zelle_sender_name')->nullable();
            $table->string('zelle_screenshot_path')->nullable();

            // Extra
            $table->json('meta')->nullable();               // any extra gateway data
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');

            $table->timestamps();

            $table->index(['membership_id', 'status']);
            $table->index('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
