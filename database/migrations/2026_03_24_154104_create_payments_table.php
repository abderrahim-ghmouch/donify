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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('donation_id')->nullable()->constrained()->onDelete('cascade');


            $table->enum('payment_method', ['stripe', 'paypal', 'credit_card', 'bank_transfer', 'apple_pay', 'google_pay'])->default('stripe');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('MAD');

            // Payment status: pending, processing, completed, failed, refunded
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded', 'cancelled'])->default('pending');

            // Transaction/Reference IDs
            $table->string('transaction_id')->nullable()->unique();
            $table->string('reference_id')->nullable();

            // Stripe specific fields
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_account_id')->nullable();
            $table->string('stripe_charge_id')->nullable();

            // PayPal specific fields
            $table->string('paypal_transaction_id')->nullable();
            $table->string('paypal_payer_id')->nullable();

            // Generic provider data (JSON)
            $table->json('provider_data')->nullable();

            // Error/Response message
            $table->text('response_message')->nullable();

            // Timestamps
            $table->timestamps();

            // Indexes for performance
            $table->index('user_id');
            $table->index('donation_id');
            $table->index('payment_method');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
