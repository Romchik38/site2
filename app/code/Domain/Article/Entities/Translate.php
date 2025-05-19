<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Entities;

use DateTime;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

/** @todo refactor with VO */
final class Translate
{
    public function __construct(
        public readonly LanguageId $language,
        public readonly string $name,
        public readonly string $shortDescription,
        public readonly string $description,
        public readonly DateTime $createdAt,
        public readonly DateTime $updatedAt
    ) {
    }
}
