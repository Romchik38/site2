<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author\VO;

use InvalidArgumentException;

use function strlen;

final class AuthorId
{
    public function __construct(
        protected readonly string $authorId
    ) {
        if (strlen($authorId) === 0) {
            throw new InvalidArgumentException('param authorId is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->authorId;
    }

    public function __toString(): string 
    {
        return $this->authorId;  
    }
}
