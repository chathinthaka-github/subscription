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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn', 20);
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('renewal_plan_id')->nullable()->constrained('renewal_plans')->nullOnDelete();
            $table->enum('status', ['pending', 'active', 'suspended', 'cancelled'])->default('pending');
            $table->dateTime('subscribed_at');
            $table->dateTime('last_renewal_at')->nullable();
            $table->dateTime('next_renewal_at')->nullable();
            $table->timestamps();

            $table->unique(['msisdn', 'service_id']);
            $table->index(['service_id', 'status']);
            $table->index(['renewal_plan_id', 'next_renewal_at']);
            $table->index('msisdn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

