<?php

namespace App\Exception;

class TimeStartErrorException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('start the timer first');
    }
}
