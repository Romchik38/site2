<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\Entities;

use Romchik38\Site2\Domain\Audio\VO\Size;
use Romchik38\Site2\Domain\Audio\VO\Type;

final class Content
{
    public function __construct(
        private readonly string $data,
        private readonly Type $type,
        private readonly Size $size
    ) {
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getSize(): Size
    {
        return $this->size;
    }
}
