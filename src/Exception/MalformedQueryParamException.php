<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

use JSONAPI\Error\Error;
use JSONAPI\Source\Source;

final class MalformedQueryParamException extends AbstractValidationException
{
    public const string ERROR_CODE = 'malformed_query_param';

    private function __construct(
        private readonly string $queryParam,
    ) {
        parent::__construct(sprintf('The provided query params "%s" is malformed.', $this->queryParam), 400);
    }

    public static function new(string $queryParam): self
    {
        return new self($queryParam);
    }

    #[\Override]
    public function errors(): array
    {
        return [
            Error::error(
                (string) $this->code,
                self::ERROR_CODE,
                'Malformed query param.',
                $this->message
            )
                ->withSource(
                    Source::parameter($this->queryParam)
                ),
        ];
    }
}
