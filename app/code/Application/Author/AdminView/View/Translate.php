<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminView\View;

use Romchik38\Site2\Domain\Author\VO\Description;
use Romchik38\Site2\Domain\Language\VO\Identifier;

final readonly class Translate
{
    public function __construct(
        public Identifier $language,
        public Description $description
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
