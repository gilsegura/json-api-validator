<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

use JSONAPI\Error\Error;
use JSONAPI\Source\Source;

final class UnsupportedMediaTypeException extends AbstractValidationException
{
    public const string ERROR_CODE = 'unsupported_media_type';

    private function __construct()
    {
        parent::__construct('The provided media type is unsupported.', 415);
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
                'Unsupported media type.',
                $this->message
            )
                ->withSource(
                    Source::parameter('content-type')
                ),
        ];
    }
}
