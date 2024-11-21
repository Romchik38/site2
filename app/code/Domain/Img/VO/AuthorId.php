<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Img\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class AuthorId
{
    protected function __construct(
        protected readonly string $authorId
    ) {}

    public static function fromString(string $authorId): self
    {
        if (strlen($authorId) === 0) {
            throw new InvalidArgumentException('param authorId is empty');
        }
        return new self($authorId);
    }

    public function __invoke(): string
    {
        return $this->authorId;
    }
}
