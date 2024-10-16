<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Link;

use Romchik38\Server\Models\ModelFactory;
use Romchik38\Site2\Api\Models\Virtual\Link\{LinkInterface, LinkFactoryInterface};

class LinkFactory extends ModelFactory implements LinkFactoryInterface
{
    public function create(): LinkInterface
    {
        return new Link();
    }
}
