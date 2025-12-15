<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run this migration if services table exists with old structure (for existing databases)
        if (!Schema::hasTable('services')) {
            return; // Table doesn't exist yet, will be created with correct structure by create_services_table migration
        }

        // Check if table already has shortcode_id column (already migrated)
        if (Schema::hasColumn('services', 'shortcode_id')) {
            return; // Already migrated
        }

        // First, create a default shortcode if none exists (for existing data migration)
        $defaultShortcodeId = DB::table('shortcodes')->insertGetId([
            'shortcode' => 'DEFAULT',
            'description' => 'Default shortcode for existing services',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('services', function (Blueprint $table) use ($defaultShortcodeId) {
            // Remove unique constraints if they exist
            if (Schema::hasColumn('services', 'shortcode')) {
                try {
                    $table->dropUnique(['shortcode']);
                } catch (\Exception $e) {
                    // Constraint might not exist, continue
                }
            }
            
            try {
                $table->dropUnique(['keyword']);
            } catch (\Exception $e) {
                // Constraint might not exist, continue
            }
            
            // Add shortcode_id foreign key
            $table->foreignId('shortcode_id')->after('id')->default($defaultShortcodeId)->constrained('shortcodes')->cascadeOnDelete();
            
            // Add composite unique index on (shortcode_id, keyword)
            $table->unique(['shortcode_id', 'keyword'], 'services_shortcode_keyword_unique');
            
            // Keep shortcode column for backward compatibility (nullable) if it exists
            if (Schema::hasColumn('services', 'shortcode')) {
                $table->string('shortcode', 20)->nullable()->change();
            }
        });

        // Migrate existing data: create shortcodes from existing services and link them
        if (Schema::hasColumn('services', 'shortcode')) {
            $services = DB::table('services')->whereNotNull('shortcode')->get();
            $shortcodeMap = [];
            
            foreach ($services as $service) {
                if (!isset($shortcodeMap[$service->shortcode])) {
                    $shortcodeId = DB::table('shortcodes')->insertGetId([
                        'shortcode' => $service->shortcode,
                        'description' => 'Migrated shortcode',
                        'status' => 'active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $shortcodeMap[$service->shortcode] = $shortcodeId;
                }
                
                DB::table('services')
                    ->where('id', $service->id)
                    ->update(['shortcode_id' => $shortcodeMap[$service->shortcode]]);
            }
        }

        // Remove default shortcode if it wasn't used
        if ($defaultShortcodeId && !DB::table('services')->where('shortcode_id', $defaultShortcodeId)->exists()) {
            DB::table('shortcodes')->where('id', $defaultShortcodeId)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Remove foreign key and composite unique
            $table->dropForeign(['shortcode_id']);
            $table->dropUnique('services_shortcode_keyword_unique');
            $table->dropColumn('shortcode_id');
            
            // Restore unique constraints
            $table->string('shortcode', 20)->nullable(false)->change();
            $table->unique('shortcode');
            $table->unique('keyword');
        });
    }
};

