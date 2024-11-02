<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

use JSONAPI\Error\Error;
use JSONAPI\Meta\Meta;
use JSONAPI\Source\Source;

final class MismatchMediaTypeException extends AbstractValidationException
{
    public const string ERROR_CODE = 'mismatch_media_type';

    private function __construct(
        private readonly string $content,
    ) {
        parent::__construct('The provided body does not match content-type.', 500);
    }

    public static function new(string $content): self
    {
        return new self($content);
    }

    #[\Override]
    public function errors(): array
    {
        return [
            Error::error(
                (string) $this->code,
                self::ERROR_CODE,
                'Mismatch media type.',
                $this->message
            )
                ->withSource(
                    Source::parameter('body')
                ),
        ];
    }

    #[\Override]
    public function meta(): array
    {
        return [
            Meta::kv('original', $this->content),
        ];
    }
}
