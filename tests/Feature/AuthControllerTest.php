<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест на успешную регистрацию пользователя.
     */
    public function testRegisterSuccess()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'phone_number' => '81234567890',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(['message' => 'Test User, registration complete.']);
    }

    /**
     * Тест на ошибочную регистрацию (недостаточно данных).
     */
    public function testRegisterValidationError()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'not-an-email',
            // 'password' => 'password123',  // Пропускаем пароль
            'phone_number' => '81234567890',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(['message', 'errors']);
    }

    /**
     * Тест на успешный вход пользователя.
     */
    public function testLoginSuccess()
    {
        $user = User::factory()->create(['password' => bcrypt('password123'), 'phone_number' => '81234567890']);

        $data = [
            'phone_number' => '81234567890',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['token']);
        $this->assertNotNull($response->cookie('token'));
    }

    /**
     * Тест на ошибочный вход (неверный пароль).
     */
    public function testLoginUnauthorized()
    {
        $user = User::factory()->create(['password' => bcrypt('password123'), 'phone_number' => '81234567890']);

        $data = [
            'phone_number' => '81234567890',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJson(['message' => 'Unauthorized']);
    }

    /**
     * Тест на успешный выход пользователя.
     */
    public function testLogoutSuccess()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Successfully logged out']);
    }
}
