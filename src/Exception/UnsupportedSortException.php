<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

use JSONAPI\Error\Error;
use JSONAPI\Source\Source;

final class UnsupportedSortException extends AbstractValidationException
{
    public const string ERROR_CODE = 'unsupported_sort';

    private function __construct()
    {
        parent::__construct('The provided sort is unsupported.', 400);
    }

    public static function new(): self
    {
        return new self();
    }

    #[\Override]
    public function errors(): array
    {
        return [
            Error::error(
                (string) $this->code,
                self::ERROR_CODE,
                'Unsupported sort.',
                $this->message
            )
                ->withSource(
                    Source::parameter('sort')
                ),
        ];
    }
}
