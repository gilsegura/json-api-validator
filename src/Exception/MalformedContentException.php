<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

use JSONAPI\Error\Error;
use JSONAPI\Meta\Meta;
use JSONAPI\Source\Source;

final class MalformedContentException extends AbstractValidationException
{
    public const string ERROR_CODE = 'malformed_content';

    private function __construct(
        private readonly string $content,
        private readonly array $errors,
    ) {
        parent::__construct('The provided content is malformed.', 400);
    }

    public static function new(string $content, array $errors): self
    {
        return new self($content, $errors);
    }

    #[\Override]
    public function errors(): array
    {
        return array_map(function (array $error): Error {
            return Error::error(
                (string) $this->code,
                self::ERROR_CODE,
                'Malformed query param.',
                $error['message']
            )
                ->withSource(
                    Source::pointer($error['pointer'])
                );
        }, $this->errors);
    }

    #[\Override]
    public function meta(): array
    {
        return [
            Meta::kv('original', $this->content),
        ];
    }
}
