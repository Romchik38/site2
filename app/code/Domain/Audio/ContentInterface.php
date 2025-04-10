<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio;

use Romchik38\Site2\Domain\Audio\VO\Size;

interface ContentInterface
{
    public function getSize(): Size;
}