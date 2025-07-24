<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading;

use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\ItemRepositoryException;
use Romchik38\Site2\Application\Article\ContinueReading\View\Item;

interface ItemRepositoryInterface
{
    /** @throws ItemRepositoryException */
    public function get(): ?Item;

    /** @throws ItemRepositoryException */
    public function update(Item $item): void;
}
