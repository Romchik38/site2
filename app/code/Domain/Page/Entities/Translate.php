<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Page\Entities;

use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\VO\Description;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\ShortDescription;

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
