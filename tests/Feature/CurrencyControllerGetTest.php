<?php

namespace Tests\Feature;

use App\Helpers\AllowedTypesOfCurrenciesHelper;
use App\Http\Requests\CurrencyGetRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\CustomTestCase;
use Tests\TestCase;

class CurrencyControllerGetTest extends CustomTestCase
{
    /** @test */
    public function test_user_must_be_authenticated()
    {
        $response = $this->get('/api/currency/get');

        $response->assertStatus(302);
    }

    /** @test */
    public function test_get() : void
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
        $data = new CurrencyGetRequest([
            'date' => now()->subDays(1)->format('Y-m-d'),
            'currency' => strtoupper($currencies[0]),
        ]);
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $responseLogin['token'],
            ])
            ->json('GET', '/api/currency/get', $data->toArray());

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
                'amount' => $response['amount'],
        ]);
        $this->assertCount(1, $response->json());
    }
}
