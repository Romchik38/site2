<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image\Entities;

use Romchik38\Site2\Domain\Image\VO\Type;

final class Content
{
    public function __construct(
        private string $data,
        private Type $type
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
}