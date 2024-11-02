<?php

declare(strict_types=1);

namespace JSONAPIValidator\Validator\QueryParam;

use JSONAPIValidator\Exception\MalformedQueryParamException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use PSR7Validator\MessageValidator;

final readonly class PaginationValidator implements MessageValidator
{
    #[\Override]
    public function validate(MessageInterface $message): void
    {
        if (!$message instanceof RequestInterface) {
            return;
        }

        parse_str($message->getUri()->getQuery(), $queryParams);

        if (!isset($queryParams['page'])) {
            return;
        }

        if (
            !isset($queryParams['page']['offset'])
            || !isset($queryParams['page']['limit'])
        ) {
            throw MalformedQueryParamException::new('page');
        }

        if (
            1 !== preg_match('/^\d$/', $queryParams['page']['offset'])
            || 1 !== preg_match('/^\d$/', $queryParams['page']['limit'])
        ) {
            throw MalformedQueryParamException::new('page');
        }
    }
}
