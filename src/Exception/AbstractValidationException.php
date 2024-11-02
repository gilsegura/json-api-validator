<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

use JSONAPI\Exception\JSONAPIExceptionInterface;
use PSR7Validator\Exception\ValidationExceptionInterface;

abstract class AbstractValidationException extends \Exception implements ValidationExceptionInterface, JSONAPIExceptionInterface
{
    #[\Override]
    public function meta(): array
    {
        return [];
    }
}
