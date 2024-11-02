<?php

declare(strict_types=1);

namespace JSONAPIValidator\Validator\Context;

use JSONAPIValidator\Validator\Header\AcceptValidator;
use JSONAPIValidator\Validator\QueryParam\FieldsValidator;
use JSONAPIValidator\Validator\QueryParam\IncludeValidator;
use JSONAPIValidator\Validator\QueryParam\SupportedQueryParamsValidator;
use Psr\Http\Message\MessageInterface;
use PSR7Validator\MessageValidator;
use PSR7Validator\ValidatorChain;

final readonly class FetchContext implements ContextInterface
{
    private function __construct(
        private MessageValidator $validator,
    ) {
    }

    public static function default(): self
    {
        return new self(
            new ValidatorChain(
                new AcceptValidator(),
                SupportedQueryParamsValidator::default()
                    ->disableSorts()
                    ->disablePages()
                    ->disableFilters(),
                new FieldsValidator(),
                new IncludeValidator()
            )
        );
    }

    #[\Override]
    public function validate(MessageInterface $message): void
    {
        $this->validator->validate($message);
    }
}
