<?php

namespace App\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

class ErrorResponse
{
    public function __construct(private readonly string $message, private readonly mixed $details = null)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    #[OA\Property(type: 'object', allOf: [new OA\Schema(ref: new Model(type: ErrorDebugDetails::class))])]
    public function getDetails(): mixed
    {
        return $this->details;
    }
}
