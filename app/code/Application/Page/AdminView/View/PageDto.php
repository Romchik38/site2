<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminView\View;

use Romchik38\Site2\Domain\Page\VO\Id;
use Romchik38\Site2\Domain\Page\VO\Url;

final readonly class PageDto
{
    /** @param array<int,TranslateDto> $translates */
    public function __construct(
        public Id $id,
        public bool $active,
        public Url $url,
        public array $translates
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getUrl(): string
    {
        return (string) $this->url;
    }
}
