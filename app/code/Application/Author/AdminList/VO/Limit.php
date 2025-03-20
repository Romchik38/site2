<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminList\VO;

use InvalidArgumentException;

use function in_array;
use function sprintf;

final class Limit
{
    public const DEFAULT_LIMIT  = 15;
    public const ALLOWED_LIMITS = [2, 5, 15, 30];

    protected function __construct(
        protected readonly int $limit
    ) {
    }

    public function __invoke(): int
    {
        return $this->limit;
    }

    public static function fromString(string $limit): self
    {
        if ($limit === '') {
            return new self(self::DEFAULT_LIMIT);
        }

        $intLimit = (int) $limit;
        $strLimit = (string) $intLimit;
        if ($strLimit !== $limit) {
            throw new InvalidArgumentException(
                sprintf('param limit %s is invalid', $limit)
            );
        }

        if (in_array($intLimit, self::ALLOWED_LIMITS) === false) {
            throw new InvalidArgumentException(
                sprintf('param limit %s is not allowed', $limit)
            );
        }

        return new self($intLimit);
    }

    public function toString(): string
    {
        return (string) $this->limit;
    }
}
