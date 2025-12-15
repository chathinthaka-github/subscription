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
        Schema::create('renewal_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('renewal_plan_id')->constrained('renewal_plans')->cascadeOnDelete();
            $table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();
            $table->string('msisdn', 20);
            $table->enum('status', ['queued', 'processing', 'done', 'failed'])->default('queued');
            $table->dateTime('queued_at')->useCurrent();
            $table->dateTime('processed_at')->nullable();
            $table->timestamps();

            $table->index(['service_id', 'status']);
            $table->index(['renewal_plan_id', 'status']);
            $table->index(['subscription_id', 'status']);
            $table->index('msisdn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renewal_jobs');
    }
};

