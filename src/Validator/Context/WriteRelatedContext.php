<?php

declare(strict_types=1);

namespace JSONAPIValidator\Validator\Context;

use JSONAPIValidator\Validator\BodyValidator;
use JSONAPIValidator\Validator\Header\AcceptValidator;
use JSONAPIValidator\Validator\Header\ContentTypeValidator;
use Psr\Http\Message\MessageInterface;
use PSR7Validator\MessageValidator;
use PSR7Validator\Schema\SchemaFactory\JsonFileFactory;
use PSR7Validator\Schema\SchemaValidator;
use PSR7Validator\ValidatorChain;

final readonly class WriteRelatedContext implements MessageValidator
{
    /** @var MessageValidator[] */
    private array $validators;

    public function __construct(
        MessageValidator ...$validators,
    ) {
        $this->validators = $validators;
    }

    public static function default(): self
    {
        return new self(
            new ValidatorChain(
                new ContentTypeValidator(),
                new AcceptValidator(),
                new BodyValidator(
                    new SchemaValidator(
                        (new JsonFileFactory(__DIR__.'/../../../schema/json-api/v1.1/write/related/schema.json'))->schema()
                    )
                )
            )
        );
    }

    #[\Override]
    public function validate(MessageInterface $message): void
    {
        foreach ($this->validators as $validator) {
            $validator->validate($message);
        }
    }
}
