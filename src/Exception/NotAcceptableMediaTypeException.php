<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

use JSONAPI\Error\Error;
use JSONAPI\Source\Source;

final class NotAcceptableMediaTypeException extends AbstractValidationException
{
    public const string ERROR_CODE = 'NOT_ACCEPTABLE_MEDIA_TYPE';

    private function __construct()
    {
        parent::__construct('The provided media type is not acceptable.', 406);
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
                'No acceptable media type.',
                $this->message
            )
                ->withSource(
                    Source::parameter('accept')
                ),
        ];
    }
}
