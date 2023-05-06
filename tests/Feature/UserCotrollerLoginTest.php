<?php

namespace Tests\Feature;

use App\Helpers\PermissionRolesHelper;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\CustomTestCase;

class UserCotrollerLoginTest extends CustomTestCase
{

    /** @test */
    public function it_returns_error_if_required_fields_are_missing()
    {
        $response = $this->postJson('/api/login', []);
        $response->assertStatus(422);

        $errors = $response->json()['errors'];
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('password', $errors);
    }

    /** @test */
    public function it_returns_error_if_email_is_invalid()
    {
        $data = [
            'email' => 'invalid_email',
            'password' => 'password123',
        ];
        $response = $this->postJson('/api/login', $data);
        $response->assertStatus(422);

        $errors = $response->json()['errors'];
        $this->assertArrayHasKey('email', $errors);
    }

    /** @test */
    public function it_returns_error_if_password_is_too_short()
    {
        $data = [
            'email' => 'test@example.com',
            'password' => 'short',
        ];
        $response = $this->postJson('/api/login', $data);
        $response->assertStatus(422);

        $errors = $response->json()['errors'];
        $this->assertArrayHasKey('password', $errors);
    }

    /** @test */
    public function test_user_login_success()
    {
        $email = 'user@mail.com';
        $password = 'password';
        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertSuccessful();

        $response->assertJson([
            'email' => $response['email'],
            'token' => $response['token'],
            'roles' => [PermissionRolesHelper::USER_ROLE],
        ]);
    }

    /** @test */
    public function test_user_not_found()
    {
        $email = 'user@mail.com';
        $password = 'password';
        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $email,
            'password' => 'test12345',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
