<?php

namespace App\Exception;

class BadCredentialsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid credentials');
    }
}
