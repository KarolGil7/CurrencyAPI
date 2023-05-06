<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'user@mail.com',
            'password' => Hash::make('userpassword')
        ]);

        User::factory()->adminRole()->create([
            'email' => 'admin@mail.com',
            'password' => Hash::make('adminpassword')
        ]);
    }
}
