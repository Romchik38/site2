<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView\VO;

use InvalidArgumentException;

final class Offset
{
    public function __construct(
        public readonly int $offset
    ) {
        if($offset < 0) {
            throw new InvalidArgumentException(
                sprintf('param offset %s is invalid', $offset)
            );
        }
    }

    public function __invoke(): int
    {
        return $this->offset;
    }
}