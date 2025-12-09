<?php

namespace Database\Seeders;

use App\Models\Shortcode;
use Illuminate\Database\Seeder;

class ShortcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shortcodes = [
            [
                'shortcode' => '1234',
                'description' => 'Main subscription shortcode',
                'status' => 'active',
            ],
            [
                'shortcode' => '5678',
                'description' => 'Premium service shortcode',
                'status' => 'active',
            ],
            [
                'shortcode' => '9999',
                'description' => 'Test shortcode',
                'status' => 'active',
            ],
        ];

        foreach ($shortcodes as $shortcode) {
            Shortcode::firstOrCreate(
                ['shortcode' => $shortcode['shortcode']],
                $shortcode
            );
        }
    }
}

