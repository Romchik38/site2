<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\List\View;

use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Banner\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

final class BannerDto
{
    public function __construct(
        public readonly BannerId $id,
        public readonly Name $name,
        public readonly ImageId $imageId
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getImageId(): string
    {
        return (string) $this->imageId;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }
}
