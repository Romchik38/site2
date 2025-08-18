<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Visitor\VO;

final class LastVisitedArticles
{
    public function __construct(
        public string $first,
        public ?string $second = null
    ) {
    }
}
