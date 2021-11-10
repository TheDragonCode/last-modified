<?php

namespace Helldar\LastModified\Exceptions;

use Exception;
use Throwable;

class UrlNotFoundException extends Exception
{
    public function __construct(string $model, Throwable $previous = null)
    {
        $class_name = get_class($model);

        $message = "The URL field not found in model $class_name";

        parent::__construct($message, 400, $previous);
    }
}
