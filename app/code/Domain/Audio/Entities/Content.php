<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\Entities;

use Romchik38\Site2\Domain\Audio\VO\Size;
use Romchik38\Site2\Domain\Audio\VO\Type;

final readonly class Content
{
    public function __construct(
        private string $data,
        private Type $type,
        private Size $size
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
