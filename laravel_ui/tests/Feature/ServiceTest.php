<?php

use App\Models\Service;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->user = User::factory()->create(['status' => 'active']);
    $role = Role::create(['name' => 'test_role']);
    $permission = Permission::create(['name' => 'service.view']);
    $role->givePermissionTo($permission);
    $this->user->assignRole($role);
});

test('user can view services index', function () {
    $this->actingAs($this->user);
    
    $response = $this->get('/services');
    
    $response->assertStatus(200);
});

test('user can create service', function () {
    Permission::firstOrCreate(['name' => 'service.create']);
    $this->user->givePermissionTo('service.create');
    $this->actingAs($this->user);
    
    $response = $this->post('/services', [
        'shortcode' => 'TEST',
        'keyword' => 'TESTKEY',
        'status' => 'active',
        'fpmt_enabled' => false,
    ]);
    
    $response->assertRedirect('/services');
    $this->assertDatabaseHas('services', [
        'shortcode' => 'TEST',
        'keyword' => 'TESTKEY',
    ]);
});

test('user cannot create service without permission', function () {
    $this->actingAs($this->user);
    
    $response = $this->post('/services', [
        'shortcode' => 'TEST',
        'keyword' => 'TESTKEY',
        'status' => 'active',
    ]);
    
    $response->assertStatus(403);
});

