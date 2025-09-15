<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\View\View;

use Romchik38\Site2\Domain\Page\VO\Description;
use Romchik38\Site2\Domain\Page\VO\Id;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\ShortDescription;
use Romchik38\Site2\Domain\Page\VO\Url;

final readonly class PageDto
{
    public function __construct(
        public Id $id,
        public Url $url,
        public Name $name,
        public ShortDescription $shortDescription,
        public Description $description,
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
