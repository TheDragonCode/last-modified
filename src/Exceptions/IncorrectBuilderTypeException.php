<?php

namespace Helldar\LastModified\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Builder;

class IncorrectBuilderTypeException extends Exception
{
    public function __construct(string $classname)
    {
        $message = \sprintf('Item must be an instance of %s, instance of %s given.', Builder::class, $classname);

        parent::__construct($message, 400);
    }
}
