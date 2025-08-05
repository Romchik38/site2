<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Visitor;

final class Visitor
{
    public function __construct(
        private(set) bool $isAccepted
    ) {   
    }

    public function acceptWithTerms(): void
    {
        $this->isAccepted = true;
    }
}