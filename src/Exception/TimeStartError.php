<?php

namespace App\Exception;

class TimeStartError extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('start the timer first');
    }
}
