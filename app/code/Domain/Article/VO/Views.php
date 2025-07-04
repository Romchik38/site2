<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\VO;

use InvalidArgumentException;

use function sprintf;

final class Views
{
    /** @throws InvalidArgumentException */
    public function __construct(
        private readonly int $views
    ) {
        if ($views < 0) {
            throw new InvalidArgumentException('param article views is less than 0');
        }
    }

    public function __invoke(): int
    {
        return $this->views;
    }

    public function __toString(): string
    {
        return (string) $this->views;
    }

    /** @throws InvalidArgumentException */
    public static function fromString(string $views): self
    {
        $oldValue = $views;
        $viewsId  = (int) $views;
        $strId    = (string) $viewsId;
        if ($oldValue !== $strId) {
            throw new InvalidArgumentException(sprintf(
                'param article views %s is invalid',
                $views
            ));
        }

        return new self($viewsId);
    }
}
