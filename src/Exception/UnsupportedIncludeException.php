<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

use JSONAPI\Error\Error;
use JSONAPI\Source\Source;

final class UnsupportedIncludeException extends AbstractValidationException
{
    public const string ERROR_CODE = 'unsupported_include';

    private function __construct()
    {
        parent::__construct('The provided include is unsupported.', 400);
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
                'Unsupported include.',
                $this->message
            )
                ->withSource(
                    Source::parameter('include')
                ),
        ];
    }
}
