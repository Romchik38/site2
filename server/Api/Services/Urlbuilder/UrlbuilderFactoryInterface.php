<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services\Urlbuilder;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

interface UrlbuilderFactoryInterface
{
    /** @throws InvalidArgumentException params can't be empty */
    public function create(
        array $path,
        string $language
    ): UrlbuilderInterface;
}
