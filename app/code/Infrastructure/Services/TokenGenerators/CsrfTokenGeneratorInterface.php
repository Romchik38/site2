<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\TokenGenerators;

interface CsrfTokenGeneratorInterface
{
    /**
     * Generate random Base64 string
     *
     * @throws CouldNotGenerateException
     * */
    public function asBase64(): string;
}
