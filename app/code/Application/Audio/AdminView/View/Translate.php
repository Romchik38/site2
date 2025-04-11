<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminView\View;

use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Language\VO\Identifier;

final class Translate
{
    /** @todo add Path */
    public function __construct(
        public readonly Identifier $language,
        public readonly Description $description
    ) {
    }

    public function getLanguage(): Identifier
    {
        return $this->language;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }
}
