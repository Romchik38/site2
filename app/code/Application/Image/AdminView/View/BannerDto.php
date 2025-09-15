<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Banner\VO\Name;

final readonly class BannerDto
{
    public function __construct(
        public BannerId $id,
        public bool $active,
        public Name $name,
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
}
