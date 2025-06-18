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
    public const ERROR_ACTIVATE_IMAGE_NOT_ACTIVE = 'Could not activate banner, image is not active';
    public const ERROR_ID_IS_NULL                = 'Active banner could not have empty id';

    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly ?Identifier $id,
        private(set) bool $active,
        public Name $name,
        public readonly Image $image
    ) {
        if ($active === true) {
            if ($image->active === false) {
                throw new InvalidArgumentException(self::ERROR_IMAGE_NOT_ACTIVE);
            }
            if ($id === null) {
                throw new InvalidArgumentException(self::ERROR_ID_IS_NULL);
            }
        }
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
        if ($this->id === null) {
            throw new InvalidArgumentException(self::ERROR_ID_IS_NULL);
        }
        $this->active = true;
    }

    /** @throws InvalidArgumentException */
    public static function create(Name $name, Image $image): self
    {
        return new self(
            null,
            false,
            $name,
            $image
        );
    }

    public function deactivate(): void
    {
        $this->active = false;
    }
}
