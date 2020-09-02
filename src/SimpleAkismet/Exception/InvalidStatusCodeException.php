<?php
declare(strict_types=1);

namespace SimpleAkismet\Exception;


use Throwable;

class InvalidStatusCodeException extends \Exception
{
    public function __construct($message = 'Unexpected status code returned from akismet API', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}