<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\ImageCache\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Type
{
    protected const ALLOWED_TYPES = ['webp'];

    public function __construct(
        protected readonly string $type
    ) {
        if (in_array($type, self::ALLOWED_TYPES) === false) {
            throw new InvalidArgumentException(
                sprintf('param type has not allowed value %s', $type)
            );
        }
    }

    public function __invoke(): string
    {
        return $this->type;
    }
}
