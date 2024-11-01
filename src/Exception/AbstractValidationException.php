<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

abstract class AbstractValidationException extends \Exception implements JSONAPIValidationExceptionInterface
{
    #[\Override]
    abstract public function errors(): array;

    #[\Override]
    public function meta(): array
    {
        return [];
    }
}
