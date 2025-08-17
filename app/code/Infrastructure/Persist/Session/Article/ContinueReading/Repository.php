<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Session\Article\ContinueReading;

use Romchik38\Server\Http\Utils\Session\SessionInterface;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\ItemRepositoryException;
use Romchik38\Site2\Application\Article\ContinueReading\ItemRepositoryInterface;
use Romchik38\Site2\Application\Article\ContinueReading\View\Item;

use function serialize;
use function unserialize;

final class Repository implements ItemRepositoryInterface
{
    public const ARTICLE_LAST_VISITED = 'article_last_visited';

    public function __construct(
        private readonly SessionInterface $session,
    ) {
    }

    public function get(): ?Item
    {
        $sessionItemData = $this->session->getData(self::ARTICLE_LAST_VISITED);
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
        $this->session->setData(self::ARTICLE_LAST_VISITED, serialize($item));
    }
}
