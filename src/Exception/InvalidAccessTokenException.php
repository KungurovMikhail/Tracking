<?php

namespace App\Exception;

class InvalidAccessTokenException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid access token');
    }
}
