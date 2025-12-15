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
        Schema::create('service_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->enum('message_type', ['FPMT', 'RENEWAL']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('message', 260);
            $table->string('price_code', 50)->nullable();
            $table->timestamps();

            $table->unique(['service_id', 'message_type']);
            $table->index(['status', 'message_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_messages');
    }
};

