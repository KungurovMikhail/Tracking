<?php

namespace App\Exception;

class FileFormatException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid File format');
    }
}
