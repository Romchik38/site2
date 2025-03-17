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

    public function __invoke(): string
    {
        return $this->id;
    }
}
