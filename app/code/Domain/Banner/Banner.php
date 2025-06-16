<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Banner;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Banner\Entities\Image;
use Romchik38\Site2\Domain\Banner\VO\Identifier;
use Romchik38\Site2\Domain\Banner\VO\Name;

final class Banner
{
    public const ERROR_IMAGE_NOT_ACTIVE          = 'Image is not active';
    public const ERROR_CHANGE_IMAGE_NOT_ACTIVE   = 'Could not change image, it is not active';
    public const ERROR_ACTIVATE_IMAGE_NOT_ACTIVE = 'Could not activate banner, image is not active';

    /** @throws InvalidArgumentException */
    public function __construct(
        private(set) Identifier $id,
        private(set) bool $active,
        public Name $name,
        private(set) Image $image
    ) {
        if ($active === true) {
            if ($image->active === false) {
                throw new InvalidArgumentException(self::ERROR_IMAGE_NOT_ACTIVE);
            }
        }
    }

    /** @throws InvalidArgumentException */
    public function changeImage(Image $image): void
    {
        if ($this->active === true && $image->active === false) {
            throw new InvalidArgumentException(self::ERROR_CHANGE_IMAGE_NOT_ACTIVE);
        }
        $this->image = $image;
    }

    /** @throws CouldNotChangeActivityException */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
        }
        if ($this->image->active === false) {
            throw new CouldNotChangeActivityException(self::ERROR_ACTIVATE_IMAGE_NOT_ACTIVE);
        }
        $this->active = true;
    }

    public function deactivate(): void
    {
        $this->active = false;
    }
}
