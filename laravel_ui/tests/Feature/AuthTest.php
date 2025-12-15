<?php

use App\Models\User;

test('user can login with username', function () {
    $user = User::factory()->create([
        'username' => 'testuser',
        'password' => bcrypt('password'),
        'status' => 'active',
    ]);

    $response = $this->post('/login', [
        'username' => 'testuser',
        'password' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});

test('user cannot login with invalid credentials', function () {
    $response = $this->post('/login', [
        'username' => 'invalid',
        'password' => 'wrong',
    ]);

    $response->assertSessionHasErrors('username');
    $this->assertGuest();
});

test('user can logout', function () {
    $user = User::factory()->create(['status' => 'active']);
    
    $this->actingAs($user);
    
    $response = $this->post('/logout');
    
    $response->assertRedirect('/login');
    $this->assertGuest();
});

