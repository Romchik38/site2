<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\View\View;

use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\Url;

final class ListDto
{
    public function __construct(
        public readonly Url $url,
        public readonly Name $name
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
