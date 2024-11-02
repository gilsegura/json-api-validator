<?php

declare(strict_types=1);

namespace JSONAPIValidator\Validator\QueryParam;

use JSONAPIValidator\Exception\UnrecognizedQueryParamException;
use JSONAPIValidator\Exception\UnsupportedIncludeException;
use JSONAPIValidator\Exception\UnsupportedSortException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use PSR7Validator\MessageValidator;

final readonly class SupportedQueryParamsValidator implements MessageValidator
{
    private function __construct(
        private array $supported,
    ) {
    }

    public static function default(): self
    {
        return new self(['fields', 'include', 'sort', 'page', 'filter']);
    }

    #[\Override]
    public function validate(MessageInterface $message): void
    {
        if (!$message instanceof RequestInterface) {
            return;
        }

        parse_str($message->getUri()->getQuery(), $queryParams);

        $unrecognized = array_diff(array_keys($queryParams), $this->supported);

        if ([] !== $unrecognized) {
            if (in_array('include', $unrecognized, true)) {
                throw UnsupportedIncludeException::new();
            }

            if (in_array('sort', $unrecognized, true)) {
                throw UnsupportedSortException::new();
            }

            throw UnrecognizedQueryParamException::new(reset($unrecognized));
        }
    }

    public function disableFields(): self
    {
        $supported = $this->supported;

        unset($supported[array_search('fields', $supported, true)]);

        return new self($supported);
    }

    public function disableIncludes(): self
    {
        $supported = $this->supported;

        unset($supported[array_search('include', $supported, true)]);

        return new self($supported);
    }

    public function disableSorts(): self
    {
        $supported = $this->supported;

        unset($supported[array_search('sort', $supported, true)]);

        return new self($supported);
    }

    public function disablePages(): self
    {
        $supported = $this->supported;

        unset($supported[array_search('page', $supported, true)]);

        return new self($supported);
    }

    public function disableFilters(): self
    {
        $supported = $this->supported;

        unset($supported[array_search('filter', $supported, true)]);

        return new self($supported);
    }
}
