<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Removes price_code from service_messages table.
     * Price code is now stored only in renewal_plans table.
     */
    public function up(): void
    {
        Schema::table('service_messages', function (Blueprint $table) {
            $table->dropColumn('price_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_messages', function (Blueprint $table) {
            $table->string('price_code', 50)->nullable()->after('message_type');
        });
    }
};
