<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration restructures the database to:
     * 1. Remove redundant renewal_plan_id from subscriptions (derived via service)
     * 2. Add unique constraint to enforce one renewal plan per service
     * Note: price_code is kept in renewal_plans as optional field
     */
    public function up(): void
    {
        // Step 1: Remove renewal_plan_id from subscriptions (if it exists)
        if (Schema::hasColumn('subscriptions', 'renewal_plan_id')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                // Check and drop foreign key if exists
                $foreignKeys = $this->getForeignKeys('subscriptions');
                if (in_array('subscriptions_renewal_plan_id_foreign', $foreignKeys)) {
                    $table->dropForeign(['renewal_plan_id']);
                }
                
                // Check and drop composite index if exists
                $indexes = $this->getIndexes('subscriptions');
                if (in_array('subscriptions_renewal_plan_id_next_renewal_at_index', $indexes)) {
                    $table->dropIndex(['renewal_plan_id', 'next_renewal_at']);
                }
                
                // Drop the column
                $table->dropColumn('renewal_plan_id');
            });
        }
        
        // Add optimized index for renewal queries if not exists
        $indexes = $this->getIndexes('subscriptions');
        if (!in_array('subscriptions_service_id_next_renewal_at_index', $indexes)) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->index(['service_id', 'next_renewal_at']);
            });
        }

        // Step 2: Add unique constraint on service_id (one plan per service) if not exists
        $indexes = $this->getIndexes('renewal_plans');
        if (!in_array('renewal_plans_service_id_unique', $indexes)) {
            Schema::table('renewal_plans', function (Blueprint $table) {
                $table->unique('service_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore renewal_plans
        $indexes = $this->getIndexes('renewal_plans');
        if (in_array('renewal_plans_service_id_unique', $indexes)) {
            Schema::table('renewal_plans', function (Blueprint $table) {
                $table->dropUnique(['service_id']);
            });
        }

        // Restore subscriptions
        if (!Schema::hasColumn('subscriptions', 'renewal_plan_id')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                // Drop new index if exists
                $indexes = $this->getIndexes('subscriptions');
                if (in_array('subscriptions_service_id_next_renewal_at_index', $indexes)) {
                    $table->dropIndex(['service_id', 'next_renewal_at']);
                }
                
                $table->foreignId('renewal_plan_id')->nullable()->after('service_id')->constrained('renewal_plans')->nullOnDelete();
                $table->index(['renewal_plan_id', 'next_renewal_at']);
            });
        }
    }
    
    /**
     * Get all foreign keys for a table.
     */
    private function getForeignKeys(string $table): array
    {
        $database = config('database.connections.mysql.database');
        $results = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ", [$database, $table]);
        
        return array_map(fn($r) => $r->CONSTRAINT_NAME, $results);
    }
    
    /**
     * Get all indexes for a table.
     */
    private function getIndexes(string $table): array
    {
        $database = config('database.connections.mysql.database');
        $results = DB::select("
            SELECT DISTINCT INDEX_NAME 
            FROM information_schema.STATISTICS 
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
        ", [$database, $table]);
        
        return array_map(fn($r) => $r->INDEX_NAME, $results);
    }
};
