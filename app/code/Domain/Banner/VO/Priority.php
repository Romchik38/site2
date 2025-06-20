<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Banner\VO;

use InvalidArgumentException;

use function sprintf;

final class Priority
{
    public const MIN_PRIORITY = 1;
    public const MAX_PRIORITY = 100;

    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly int $piority
    ) {
        if ($piority < self::MIN_PRIORITY || $piority > self::MAX_PRIORITY) {
            throw new InvalidArgumentException(sprintf('Invalid banner priority %d', $piority));
        }
    }

    public function __invoke(): int
    {
        return $this->piority;
    }

    public function __toString(): string
    {
        return (string) $this->piority;
    }

    /** @throws InvalidArgumentException */
    public static function fromString(string $piority): self
    {
        $oldValue = $piority;
        $intId    = (int) $piority;
        $strId    = (string) $intId;
        if ($oldValue !== $strId) {
            throw new InvalidArgumentException(sprintf(
                'param banner piority %s is invalid',
                $piority
            ));
        }

        return new self($intId);
    }
}
