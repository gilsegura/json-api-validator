<?php

declare(strict_types=1);

namespace JSONAPIValidator\Exception;

use JSONAPI\Error\Error;
use JSONAPI\Source\Source;

final class UnrecognizedQueryParamException extends AbstractValidationException
{
    public const string ERROR_CODE = 'unrecognized_query_params';

    private function __construct(
        private readonly string $queryParam,
    ) {
        parent::__construct(sprintf('The provided query params "%s" is unrecognized.', $this->queryParam), 400);
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
                'Unrecognized query params.',
                $this->message
            )
                ->withSource(
                    Source::parameter($this->queryParam)
                ),
        ];
    }
}
