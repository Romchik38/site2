<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services\Urlbuilder;

interface UrlbuilderInterface
{
    /** @return string main part of the url */
    public function prefix(): string;

    /** @return string concatenate main part with given part */
    public function add(string $part): string;
}
