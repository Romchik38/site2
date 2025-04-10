<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\Entities;

use Romchik38\Site2\Domain\Audio\VO\Size;
use Romchik38\Site2\Domain\Audio\ContentInterface;

final class ContentUseMp3Info implements ContentInterface
{
    public function __construct(
        private readonly ContentUseMp3Info $data,
        private readonly Size $size
    ) {
    }

    public function getSize(): Size
    {
        return $this->size;
    }
}
