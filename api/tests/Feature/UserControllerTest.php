<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_can_be_instantiated(): void
    {
        // Create new user
        $user = User::factory()->create();

        // Assert that the model exists in the database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);

        // Assert that it's an instance of the correct class
        $this->assertInstanceOf(\App\Models\User::class, $user);

        // Assert attributes
        $this->assertNotNull($user->name);
        $this->assertNotNull($user->email);
    }

    public function test_getUser(): void
    {
        // Create new user
        $user = User::factory()->create();

        // Send api request
        $response = $this->actingAs($user)->getJson('api/user');

        // Assert api response
        $response->assertStatus(200)
                ->assertJson([
                     'id' => $user->id,
                     'email' => $user->email,
                     'name' => $user->name,
                ]);
    }

    public function test_update(): void
    {
        // Create new user
        $user = User::factory()->create([
            'name' => 'x',
            'email' => 'x@gmail.com',
            'password' => bcrypt('xpass'),
        ]);

        // Update details
        $payload = [
            'name' => 'y',
            'email' => 'y@gmail.com',
            'password' => 'ypass',
        ];

        // Send api request
        $response = $this->actingAs($user)->putJson('api/user/update', $payload);
        
        // Compare values to ensure everything worked as expected
        $response->assertStatus(200)
                 ->assertJson(['message' => 'User updated successfully'])
                 ->assertJsonPath('user.name', 'y')
                 ->assertJsonPath('user.email', 'y@gmail.com');

        $this->assertTrue(Hash::check('ypass', $user->fresh()->password));
    }

    public function test_delete(): void
    {
        // Create new user
        $user = User::factory()->create();

        // Send api request
        $response = $this->actingAs($user)->deleteJson('api/user/delete');

        // Assert api response
        $response->assertStatus(200);
        $response->assertJson(['message' => 'User deleted successfully']);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);

    }
}
