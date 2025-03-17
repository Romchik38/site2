<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Img\VO;

use InvalidArgumentException;

final class Path
{
    public function __construct(
        protected readonly string $path
    ) {
        if (strlen($path) === 0) {
            throw new InvalidArgumentException('param path is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->path;
    }
}
