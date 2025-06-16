<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\AdminList\View;

use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Banner\VO\Name;

final class BannerDto
{
    public function __construct(
        public readonly BannerId $id,
        public readonly bool $active,
        public readonly Name $name,
        public readonly ImageDto $image
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
