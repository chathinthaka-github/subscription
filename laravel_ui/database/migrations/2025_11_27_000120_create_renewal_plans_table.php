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
        Schema::create('renewal_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->string('name', 100);
            $table->enum('plan_type', ['daily', 'weekly', 'monthly']);
            $table->json('schedule_rules');
            $table->boolean('skip_subscription_day')->default(false);
            $table->boolean('is_fixed_time')->default(false);
            $table->time('fixed_time')->nullable()->comment('Time in HH:mm format');
            $table->dateTime('start_from')->nullable();
            $table->timestamps();

            $table->index(['service_id', 'plan_type']);
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renewal_plans');
    }
};

