<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        if (! $adminRole) {
            $this->call(RolePermissionSeeder::class);
            $adminRole = Role::where('name', 'admin')->first();
        }

        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );

        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}

