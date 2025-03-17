<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Img\VO;

use InvalidArgumentException;

final class Id
{
    public function __construct(
        protected readonly string $id
    ) {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('param id is empty');
        }        
    }

    /** @todo remove as duplicate of __construct */
    public static function fromString(string $id): self
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('param id is empty');
        }
        return new self($id);
    }

    public function __invoke(): string
    {
        return $this->id;
    }
}
