<?php

declare(strict_types=1);

namespace JSONAPIValidator\Validator\QueryParam;

use JSONAPIValidator\Exception\MalformedQueryParamException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use PSR7Validator\MessageValidator;

final readonly class SortingValidator implements MessageValidator
{
    #[\Override]
    public function validate(MessageInterface $message): void
    {
        if (!$message instanceof RequestInterface) {
            return;
        }

        parse_str($message->getUri()->getQuery(), $queryParams);

        if (!isset($queryParams['sort'])) {
            return;
        }

        if (1 !== preg_match('/^-?[a-z]+(?:,-?[a-z]+)*/', $queryParams['sort'])) {
            throw MalformedQueryParamException::new('sort');
        }
    }
}
