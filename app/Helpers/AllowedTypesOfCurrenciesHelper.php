<?php

namespace App\Helpers;

class AllowedTypesOfCurrenciesHelper
{
    public static function getCurrencyTypes(): array
    {
        return ['EUR', 'USD', 'GBP'];
    }
}
