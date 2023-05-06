<?php

namespace Tests\Feature;

use App\Http\Requests\CurrencyGetAllRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\CustomTestCase;
use Tests\TestCase;

class CurrencyControllerGetAllTest extends CustomTestCase
{
    /** @test */
    public function test_user_must_be_authenticated()
    {
        $response = $this->get('/api/currency/get-all?per_page=10&page_number=2');

        $response->assertStatus(302);
    }

    /** @test */
    public function test_get_all() : void
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

        $data = new CurrencyGetAllRequest([
            'date' => now()->format('Y-m-d'),
            'per_page' => 10,
            'page_number' => 1,
        ]);
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $responseLogin['token'],
            ])
            ->json('GET', '/api/currency/get-all', $data->toArray());

            // dd($response);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
                'currency' => $response['data'][0]['currency'],
                'date' => $response['data'][0]['date'],
                'amount' => $response['data'][0]['amount'],
        ]);
    }
}
