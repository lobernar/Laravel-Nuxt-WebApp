<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login(): void
    {
        // Create new user
        $user = User::factory()->create([
            'name' => 'x',
            'email' => 'x@gmail.com',
            'password' => bcrypt('xpass'),
        ]);

        // Request (login) payload
        $payload = [
            'name' => 'x',
            'password' => 'xpass'
        ];

        // Send api request
        $response = $this->postJson('/api/login', $payload);

        // Assert response
        $response->assertStatus(200)
                ->assertJson(['message' => 'Login successful'])
                ->assertJsonPath('user.name', 'x')
                ->assertJsonPath('user.email', 'x@gmail.com');
            
        // Assert user is authenticated
        $this->assertAuthenticatedAs($user);
    }

    public function test_logout(): void
    {
        // Create new user
        $user = User::factory()->create();

        // Act as if user is logged in
        $response = $this->actingAs($user)->postJson('/api/logout');

        // Assert the api response
        $response->assertStatus(200)
                ->assertJson(['message' => 'Logout successful']);

        // Assert user is no longer logged in
        $this->assertGuest();
    }

    public function test_register(): void
    {
        // Setup payload to register user
        $payload = [
            'name' => 'x',
            'email' => 'x@gmail.com',
            'password' => 'xpass'
        ];

        // Send api request
        $response = $this->postJson('api/register', $payload);

        // Assert response
        $response->assertStatus(200)
                ->assertJsonStructure([
                     'user' => ['id', 'name', 'email', 'created_at', 'updated_at']
                 ]);

        // Assert user is in database
        $this->assertDatabaseHas('users', [
            'name' => 'x',
            'email' => 'x@gmail.com'
        ]);

        // Assert password has been hashed
        $user = User::where('name', 'x')->first();
        $this->assertTrue(Hash::check('xpass', $user->password));
    }
}
