<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_getAllUsers(): void
    {
        // Create 3 users
        User::factory()->count(3)->create();

        // Create admin user
        $admin = User::factory()->create(['role' => 'admin']);

        // Send api request as admin
        $response = $this->actingAs($admin)->getJson('/api/admin/users');

        // Assert reponse
        $response->assertStatus(200)
                ->assertJsonCount(4); // 3 users + admin
    }

    public function test_updateUserRole(): void
    {
        // Create user and admin
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        // Set request payload
        $payload = [
            'user_id' => $user->id,
            'role' => 'manager'
        ];

        // Send api request
        $response = $this->actingAs($admin)
                        ->putJson('/api/admin/user/promote', $payload);
        
        // Assert response
        $response->assertStatus(200)
                ->assertJson([
                    'message' =>" User {$user->name} promoted to manager"
                ]);

        // Assert user changed in database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'manager'
        ]);
    }
}
