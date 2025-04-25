<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\ImageCache\VO;

use InvalidArgumentException;

use function strlen;

final class Data
{
    /** @throws InvalidArgumentException */
    public function __construct(
        protected readonly string $data
    ) {
        if (strlen($data) === 0) {
            throw new InvalidArgumentException('param data is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->data;
    }
}
