<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html;

use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;

interface UrlGeneratorInterface
{
    /** @param array<int,Query> $queries */
    public function generateUrl(array $queries): string;
}
