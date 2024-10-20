<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Views;

use Romchik38\Server\Api\Controllers\ControllerInterface;

/** convert controller tree to output format */
interface SitemapLinkTreeInterface
{
    public function getSitemapLinkTree(ControllerInterface $controller, string $action): mixed;
}
