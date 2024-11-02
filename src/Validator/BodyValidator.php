<?php

declare(strict_types=1);

namespace JSONAPIValidator\Validator;

use JSONAPIValidator\Exception\MalformedContentException;
use JSONAPIValidator\Exception\MismatchMediaTypeException;
use JSONAPIValidator\Exception\UnsupportedMediaTypeException;
use Psr\Http\Message\MessageInterface;
use PSR7Validator\MessageValidator;
use PSR7Validator\Schema\SchemaValidator;

final readonly class BodyValidator implements MessageValidator
{
    public function __construct(
        private SchemaValidator $validator,
    ) {
    }

    #[\Override]
    public function validate(MessageInterface $message): void
    {
        $contentType = $message->getHeaderLine('content-type');

        if (1 !== preg_match('/^application\/vnd\.api\+json/i', $contentType)) {
            throw UnsupportedMediaTypeException::new();
        }

        $body = $message->getBody();

        if ($body->isSeekable()) {
            $body->rewind();
        }

        if (!json_validate($body->__toString())) {
            throw MismatchMediaTypeException::new($body->__toString());
        }

        $errors = $this->validator->validate(json_decode($body->__toString()));

        if ([] !== $errors) {
            throw MalformedContentException::new($body->__toString(), $errors);
        }
    }
}
