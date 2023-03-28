<?php

namespace App\Exception;

class FileNotLoadedException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('File not loaded');
    }
}
