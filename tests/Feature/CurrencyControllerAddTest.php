<?php

namespace Tests\Feature;

use App\Helpers\AllowedTypesOfCurrenciesHelper;
use App\Http\Requests\CurrencyAddRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\CustomTestCase;
use Tests\TestCase;

class CurrencyControllerAddTest extends CustomTestCase
{
    /** @test */
    public function test_user_must_be_authenticated()
    {
        $response = $this->post('/api/currency/add');

        $response->assertStatus(302);
    }

    /** @test */
    public function test_user_forbidden_access() : void
    {

        $email = 'user@mail.com';
        $password = 'password';
        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $responseLogin = $this->postJson('/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $currencies = AllowedTypesOfCurrenciesHelper::getCurrencyTypes();
        $data = new CurrencyAddRequest([
            'date' => now()->format('Y-m-d'),
            'currency' => $currencies[0],
            'amount' => 10.01
        ]);
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $responseLogin['token'],
            ])
            ->json('POST', '/api/currency/add', $data->toArray());

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function test_admin_allowed_access() : void
    {

        $email = 'admin@mail.com';
        $password = 'adminpassword';
        $user = User::factory()->adminRole()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $responseLogin = $this->postJson('/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $currencies = AllowedTypesOfCurrenciesHelper::getCurrencyTypes();
        $data = new CurrencyAddRequest([
            'date' => now()->addYear()->format('Y-m-d'),
            'currency' => $currencies[0],
            'amount' => 10.01
        ]);
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $responseLogin['token'],
            ])
            ->json('POST', '/api/currency/add', $data->toArray());

        $response->assertStatus(201);
        $response->assertJsonFragment([
                'id' => $response['id'],
                'currency' => $response['currency'],
                'date' => $response['date'],
                'amount' => $response['amount'],
        ]);
        $this->assertCount(4, $response->json());
    }
}
