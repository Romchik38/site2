<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\VO;

use InvalidArgumentException;

use function strlen;

final class ArticleId
{
    /** @throws InvalidArgumentException - When string is empty. */
    public function __construct(
        private string $id
    ) {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }
    }

    /** @todo remove */
    public function toString(): string
    {
        return $this->id;
    }

    public function __invoke(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
