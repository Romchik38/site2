<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Page\Entities;

use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\VO\Description;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\ShortDescription;

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
