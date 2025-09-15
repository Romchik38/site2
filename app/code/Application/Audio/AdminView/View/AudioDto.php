<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminView\View;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;

final readonly class AudioDto
{
    /**
     * @param array<int,Translate> $translates
     * @param array<int,ArticleId> $articles
     */
    public function __construct(
        public Id $id,
        public bool $active,
        public Name $name,
        public array $articles,
        public array $translates
    ) {
    }
}
