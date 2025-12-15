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
        Schema::create('mt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions')->nullOnDelete();
            $table->string('msisdn', 20);
            $table->enum('message_type', ['FPMT', 'RENEWAL']);
            $table->enum('status', ['queued', 'success', 'fail'])->default('queued');
            $table->enum('dn_status', ['pending', 'success', 'fail'])->default('pending');
            $table->text('dn_details')->nullable();
            $table->string('price_code', 50)->nullable();
            $table->string('mt_ref_id', 100)->unique();
            $table->string('message', 260);
            $table->timestamps();

            $table->index(['service_id', 'status']);
            $table->index(['subscription_id', 'dn_status']);
            $table->index('msisdn');
            $table->index(['message_type', 'price_code']);
            $table->index('mt_ref_id');
            $table->index('dn_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mt');
    }
};


