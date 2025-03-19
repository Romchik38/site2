<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap;

use Romchik38\Server\Api\Controllers\ControllerInterface;

/**
 * Converts controller tree to output format
 * Place right getSitemapLinkTree for concrete View
 */
interface SitemapLinkTreeInterface
{
    /** @return mixed Output for view */
    public function getSitemapLinkTree(ControllerInterface $controller): mixed;
}
