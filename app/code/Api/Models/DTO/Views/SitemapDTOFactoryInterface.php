<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\DTO\Views;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

/**
 * Create an SitemapDTOInterface entity after few checks
 * 
 * @api
 */
interface SitemapDTOFactoryInterface
{
    /**
     * @throws InvalidArgumentException name, description, output length equal 0
     * @return SitemapDTOInterface Sitemap DTO View entity
     */
    public function create(
        string $name,
        string $description,
        string $output
    ): SitemapDTOInterface;
}
