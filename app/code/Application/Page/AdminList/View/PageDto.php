<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList\View;

use Romchik38\Site2\Domain\Page\VO\Id;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\Url;

final readonly class PageDto
{
    public function __construct(
        public Id $id,
        public bool $active,
        public ?Name $name,
        public Url $url
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getName(): ?string
    {
        if ($this->name === null) {
            return null;
        } else {
            return (string) $this->name;
        }
    }

    public function getUrl(): string
    {
        return (string) $this->url;
    }
}
