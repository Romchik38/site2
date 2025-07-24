<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Session\Article\ContinueReading;

use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\ItemRepositoryException;
use Romchik38\Site2\Application\Article\ContinueReading\ItemRepositoryInterface;
use Romchik38\Site2\Application\Article\ContinueReading\View\Item;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;

use function serialize;
use function unserialize;

final class Repository implements ItemRepositoryInterface
{
    public function __construct(
        private readonly Site2SessionInterface $session,
    ) {
    }

    public function get(): ?Item
    {
        $sessionItemData = $this->session->getData(Site2SessionInterface::ARTICLE_LAST_VISITED);
        if ($sessionItemData === null || $sessionItemData === '') {
            return null;
        }

        $item = unserialize($sessionItemData);
        if (! $item instanceof Item) {
            throw new ItemRepositoryException('Session article data is invalid');
        }
        return $item;
    }

    public function update(Item $item): void
    {
        $this->session->setData(Site2SessionInterface::ARTICLE_LAST_VISITED, serialize($item));
    }
}
