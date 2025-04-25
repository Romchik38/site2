<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\VO;

/** @todo refactor (remove) this class as unnecessary */
final class Active
{
    public const FIELD = 'active';

    public function __construct(
        public readonly bool $active
    ) {
    }

    public function __invoke(): bool
    {
        return $this->active;
    }
}
