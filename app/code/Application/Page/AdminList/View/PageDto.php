<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList\View;

use Romchik38\Site2\Domain\Page\VO\Id;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\Url;

final class PageDto
{
    public function __construct(
        public readonly Id $id,
        public readonly bool $active,
        public readonly Name $name,
        public readonly Url $url
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
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
