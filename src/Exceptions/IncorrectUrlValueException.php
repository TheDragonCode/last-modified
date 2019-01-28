<?php

namespace Helldar\LastModified\Exceptions;

use Exception;

class IncorrectUrlValueException extends Exception
{
    public function __construct(string $message, \Throwable $previous = null)
    {
        parent::__construct($message, 400, $previous);
    }
}
