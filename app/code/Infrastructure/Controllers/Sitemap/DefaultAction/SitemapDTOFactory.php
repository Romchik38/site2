<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Sitemap\DefaultAction;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

/**
 * Creates a SitemapDTO. 
 * Makes arguments checks. 
 * Used in the Sitemap action only.
 * 
 * @internal
 */
final class SitemapDTOFactory
{
    /**
    * @throws InvalidArgumentException name, description, output length equal 0
    * @return SitemapDTO Sitemap DTO View entity
    */
    public function create(
        string $name,
        string $description,
        string $output
    ): SitemapDTO {
        if (
            strlen($name) === 0 ||
            strlen($description) === 0 ||
            strlen($output) === 0
        ) {
            throw new InvalidArgumentException(
                'Arguments name, description, output must not be blank'
            );
        }

        return new SitemapDTO($name, $description, $output);
    }
}
