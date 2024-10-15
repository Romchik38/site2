<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Link;

use Romchik38\Site2\Api\Models\Link\LinkFactoryInterface;
use Romchik38\Site2\Api\Models\Link\LinkInterface;

final class LinkFactory implements LinkFactoryInterface
{
    public function create(): LinkInterface
    {
        return new Link();
    }
}
