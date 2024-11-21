<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter;

use Romchik38\Site2\Application\ImgConverter\View\AspectRatio;
use Romchik38\Site2\Application\ImgConverter\View\Id;
use Romchik38\Site2\Application\ImgConverter\View\Size;
use Romchik38\Site2\Application\ImgConverter\View\Type;

final class CreateCriteria
{
    public function __construct(
        public readonly Id $id,
        public readonly Type $type,
        public readonly AspectRatio $aspectRatio,
        public readonly Size $size
    ) {}
}
