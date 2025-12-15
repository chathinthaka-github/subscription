<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

test('authenticated user can access dashboard', function () {
    $user = User::factory()->create(['status' => 'active']);
    $role = Role::create(['name' => 'test_role']);
    $permission = Permission::create(['name' => 'reports.view']);
    $role->givePermissionTo($permission);
    $user->assignRole($role);
    
    $response = $this->actingAs($user)->get('/dashboard');
    
    $response->assertStatus(200);
    $response->assertViewIs('dashboard');
});

test('unauthenticated user cannot access dashboard', function () {
    $response = $this->get('/dashboard');
    
    $response->assertRedirect('/login');
});

