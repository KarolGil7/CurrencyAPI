<?php

namespace App\Helpers;

class PaginationHelper
{
    public static function getLimitPerPage(): array
    {
        return [10, 25, 50, 100];
    }
}
