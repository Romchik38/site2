<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\TokenGenerators;

use InvalidArgumentException;

class CsrfTokenGeneratorUseRandomBytes implements CsrfTokenGeneratorInterface
{
    public function __construct(
        protected readonly int $length
    ) {
        if($length <= 0) {
            throw new InvalidArgumentException('Length must be greater than 0');
        }
    }

    public function asBase64(): string
    {
        try {
            return base64_encode(random_bytes($this->length));
        } catch(\Random\RandomException $e) {
            throw new CouldNotGenerateException($e->getMessage());
        } catch(\ValueError $e) {
            throw new CouldNotGenerateException($e->getMessage());
        }
    }
}
