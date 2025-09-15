<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Language\List\View;

use Romchik38\Site2\Domain\Language\VO\Identifier;

final readonly class LanguageDto
{
    public function __construct(
        public Identifier $identifier,
        public bool $active
    ) {
    }

    public function getId(): string
    {
        return (string) $this->identifier;
    }
}
