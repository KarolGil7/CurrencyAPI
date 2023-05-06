<?php

namespace App\Exceptions;

use Exception;

class CurrencyExistsException extends Exception
{
    public function __construct($message = "Currency already exists for this date", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
