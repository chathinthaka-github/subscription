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
        if (!Schema::hasColumn('renewal_plans', 'price_code')) {
            Schema::table('renewal_plans', function (Blueprint $table) {
                $table->string('price_code', 50)->nullable()->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('renewal_plans', 'price_code')) {
            Schema::table('renewal_plans', function (Blueprint $table) {
                $table->dropColumn('price_code');
            });
        }
    }
};
