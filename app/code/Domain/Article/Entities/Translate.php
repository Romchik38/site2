<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Entities;

use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class Translate
{
    public function __construct(
        public readonly LanguageId $language,
        public readonly Name $name,
        public readonly ShortDescription $shortDescription,
        public readonly Description $description,
    ) {
    }
}
