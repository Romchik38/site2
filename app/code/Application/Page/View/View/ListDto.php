<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\View\View;

use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\Url;

final readonly class ListDto
{
    public function __construct(
        public Url $url,
        public Name $name
    ) {
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function getUrl(): string
    {
        return (string) $this->url;
    }
}
