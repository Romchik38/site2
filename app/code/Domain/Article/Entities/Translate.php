<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Entities;

use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final readonly class Translate
{
    public function __construct(
        public LanguageId $language,
        public Name $name,
        public ShortDescription $shortDescription,
        public Description $description,
    ) {
    }
}
