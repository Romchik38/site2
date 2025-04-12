<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminView\View;

use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;

final class AudioDto
{
    /**
     * @param array<int,Translate> $translates
     * @param array<int,ArticleId> $articles
     */
    public function __construct(
        public readonly Id $id,
        public readonly bool $active,
        public readonly Name $name,
        public readonly array $articles,
        public readonly array $translates
    ) {
    }
}
