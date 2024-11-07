<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Link;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

final class LinkFactory implements ModelFactoryInterface
{
    public function create(): Link
    {
        return new Link();
    }
}
