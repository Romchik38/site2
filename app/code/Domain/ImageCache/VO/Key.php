<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\ImageCache\VO;

use InvalidArgumentException;

use function strlen;

final class Key
{
    public function __construct(
        protected readonly string $key
    ) {
        if (strlen($key) === 0) {
            throw new InvalidArgumentException('param key is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->key;
    }
}
