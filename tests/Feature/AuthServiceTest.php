<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use \Illuminate\Validation\ValidationException;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    public function test_register_creates_user_and_returns_token()
    {
        $data = [
            'name' => 'ali',
            'email' => 'ali@gmail.com',
            'password' => 'WAC1937',
            'role' => 'client',
        ];

        $response = $this->authService->register($data);

        $this->assertDatabaseHas('users', ['email' => 'ali@gmail.com']);
        $this->assertArrayHasKey('token', $response);
        $this->assertNotNull($response['user']);
    }

    public function test_login_returns_token_for_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'ali@gmail.com',
            'password' => Hash::make('WAC1937'),
        ]);

        $credentials = [
            'email' => 'ali@gmail.com',
            'password' => 'WAC1937',
        ];

        $response = $this->authService->login($credentials);

        $this->assertArrayHasKey('token', $response);
        $this->assertEquals($user->id, $response['user']->id);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'ali@gmail.com',
            'password' => Hash::make('WAC1937'),
        ]);

        $this->expectException(ValidationException::class);

        $this->authService->login([
            'email' => 'ali@gmail.com',
            'password' => 'wrongpassword',
        ]);
    }
}
