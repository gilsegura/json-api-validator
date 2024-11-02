<?php

declare(strict_types=1);

namespace JSONAPIValidator\Validator\Header;

use JSONAPIValidator\Exception\UnsupportedMediaTypeException;
use Psr\Http\Message\MessageInterface;
use PSR7Validator\MessageValidator;

final readonly class ContentTypeValidator implements MessageValidator
{
    #[\Override]
    public function validate(MessageInterface $message): void
    {
        $contentType = $message->getHeaderLine('content-type');

        if (1 !== preg_match('/^.*application\/vnd\.api\+json\s*;\s*(?:ext|profile)\s*=".*";?.*$/i', $contentType)) {
            throw UnsupportedMediaTypeException::new();
        }
    }
}
