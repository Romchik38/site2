<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Banner;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Banner\Entities\Image;
use Romchik38\Site2\Domain\Banner\VO\Identifier;
use Romchik38\Site2\Domain\Banner\VO\Name;

final class Banner
{
    /** @throws InvalidArgumentException */
    public function __construct(
        private(set) Identifier $id,
        private(set) bool $active,
        public Name $name,
        private(set) Image $image
    ) {
        if ($active === true) {
            if ($image->active === false) {
                throw new InvalidArgumentException('Image is not active');
            }
        }
    }

    /** @throws InvalidArgumentException */
    public function changeImage(Image $image): void
    {
        if ($this->active === true && $image->active === false) {
            throw new InvalidArgumentException('Could not change image, it is not active');
        }
    }

    /** @throws CouldNotChangeActivityException */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
        }
        if ($this->image->active === false) {
            throw new InvalidArgumentException('Could not activate banner, image is not active');
        }
    }

    public function deactivate(): void
    {
        $this->active = false;
    }
}
