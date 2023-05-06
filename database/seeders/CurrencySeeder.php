<?php

namespace Database\Seeders;

use App\Helpers\AllowedTypesOfCurrenciesHelper;
use App\Models\Currency;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 14; $i++) {
            foreach (AllowedTypesOfCurrenciesHelper::getCurrencyTypes() as $currencyType) {
                $data[] = [
                    'currency_type' => $currencyType,
                    'created_at' => now()->subDays($i),
                    'amount' => $this->faker->randomFloat(2, 0.01, 10.00)
                ];
            }
        }

        Currency::insert($data);
    }
}
