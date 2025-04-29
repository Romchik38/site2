<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\TokenGenerators;

use InvalidArgumentException;
use Random\RandomException;
use ValueError;

use function base64_encode;
use function random_bytes;

final class CsrfTokenGeneratorUseRandomBytes implements CsrfTokenGeneratorInterface
{
    public function __construct(
        private readonly int $length
    ) {
        if ($length <= 0) {
            throw new InvalidArgumentException('Length must be greater than 0');
        }
    }

    public function asBase64(): string
    {
        if ($this->length <= 0) {
            throw new InvalidArgumentException('Length must be greater than 0');
        }

        try {
            return base64_encode(random_bytes($this->length));
        } catch (RandomException $e) {
            throw new CouldNotGenerateException($e->getMessage());
        } catch (ValueError $e) {
            throw new CouldNotGenerateException($e->getMessage());
        }
    }
}
