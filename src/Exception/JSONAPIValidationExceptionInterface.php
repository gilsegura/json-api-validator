<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

use PSR7Validator\Exception\ValidationExceptionInterface;

interface JSONAPIValidationExceptionInterface extends ValidationExceptionInterface
{
    public function errors(): array;

    public function meta(): array;
}
