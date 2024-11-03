<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class ArticleId
{
    /** @throws InvalidArgumentException when string is empty */
    public function __construct(
        private string $id
    ) {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }
    }

    public function toString(): string {
        return $this->id;
    }
}
