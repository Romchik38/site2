<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\DTO\Views;

use Romchik38\Site2\Api\Models\DTO\Views\SitemapDTOFactoryInterface;
use Romchik38\Site2\Api\Models\DTO\Views\SitemapDTOInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;

class SitemapDTOFactory implements SitemapDTOFactoryInterface
{
    public function create(
        string $name,
        string $description,
        string $output
    ): SitemapDTOInterface {
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
