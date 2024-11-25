<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\ImageCache;

use Romchik38\Site2\Domain\ImageCache\VO\CreatedAt;
use Romchik38\Site2\Domain\ImageCache\VO\Data;
use Romchik38\Site2\Domain\ImageCache\VO\Key;
use Romchik38\Site2\Domain\ImageCache\VO\Type;

final class ImageCache
{
    protected CreatedAt $createdAt;

    public function __construct(
        protected Key $key,
        protected Data $data,
        protected Type $type
    ) {
        $this->createdAt = new CreatedAt(new \DateTime());
    }

    public function key(): Key
    {
        return $this->key;
    }

    public function data(): Data
    {
        return $this->data;
    }

    public function type(): Type
    {
        return $this->type;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }
}
