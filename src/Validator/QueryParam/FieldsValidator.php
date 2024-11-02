<?php

declare(strict_types=1);

namespace JSONAPIValidator\Validator\QueryParam;

use JSONAPIValidator\Exception\MalformedQueryParamException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use PSR7Validator\MessageValidator;

final readonly class FieldsValidator implements MessageValidator
{
    #[\Override]
    public function validate(MessageInterface $message): void
    {
        if (!$message instanceof RequestInterface) {
            return;
        }

        parse_str($message->getUri()->getQuery(), $queryParams);

        if (!isset($queryParams['fields'])) {
            return;
        }

        if (!is_array($queryParams['fields'])) {
            throw MalformedQueryParamException::new('fields');
        }

        foreach ($queryParams['fields'] as $type => $fields) {
            if (
                1 !== preg_match('/^[a-z]+$/', $type)
                || 1 !== preg_match('/^[a-z]+(?:,[a-z]+)*$/', $fields)
            ) {
                throw MalformedQueryParamException::new('fields');
            }
        }
    }
}
