<?php

declare(strict_types=1);

namespace JSONAPIValidator\Validator\Header;

use JSONAPIValidator\Exception\NotAcceptableMediaTypeException;
use Psr\Http\Message\MessageInterface;
use PSR7Validator\MessageValidator;

final readonly class AcceptValidator implements MessageValidator
{
    #[\Override]
    public function validate(MessageInterface $message): void
    {
        $accept = $message->getHeaderLine('accept');

        if (1 !== preg_match('/^.*application\/vnd\.api\+json\s*;?\s*(?:(?:ext|profile)\s*=".*")?;?.*$/i', $accept)) {
            throw NotAcceptableMediaTypeException::new();
        }
    }
}
