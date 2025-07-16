<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\View\View;

use Romchik38\Site2\Domain\Page\VO\Description;
use Romchik38\Site2\Domain\Page\VO\Id;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\ShortDescription;
use Romchik38\Site2\Domain\Page\VO\Url;

final class PageDto
{
    public function __construct(
        public readonly Id $id,
        public readonly Url $url,
        public readonly Name $name,
        public readonly ShortDescription $shortDescription,
        public readonly Description $description,
    ) {
    }

    public function getDescription(): string
    {
        return (string) $this->description;
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function getShortDescription(): string
    {
        return (string) $this->shortDescription;
    }

    public function getUrl(): string
    {
        return (string) $this->url;
    }
}
