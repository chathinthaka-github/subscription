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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shortcode_id')->constrained('shortcodes')->cascadeOnDelete();
            $table->string('keyword', 120);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('fpmt_enabled')->default(false);
            $table->timestamps();

            // Composite unique index on (shortcode_id, keyword)
            $table->unique(['shortcode_id', 'keyword'], 'services_shortcode_keyword_unique');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

