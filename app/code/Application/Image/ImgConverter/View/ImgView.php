<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImgConverter\View;

use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Path;

final class ImgView
{
    public function __construct(
        private readonly Id $id,
        private readonly Path $path
    ) {
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function path(): Path
    {
        return $this->path;
    }
}
