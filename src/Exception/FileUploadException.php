<?php

namespace App\Exception;

class FileUploadException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Error moving upload file');
    }
}
