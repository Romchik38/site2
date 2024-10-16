<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\DTO\Html\Link;

use Romchik38\Server\Api\Models\DTO\Html\Link\LinkDTOFactoryInterface;
use Romchik38\Server\Models\DTO\Html\Link\LinkDTOCollection;

class LinkDTOCollectionUseVirtualRepository extends LinkDTOCollection {
    public function __construct(
        protected LinkDTOFactoryInterface $linkDTOFactory
    ) {}
}