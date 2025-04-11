<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminView\View;

use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Language\VO\Identifier;
use Romchik38\Site2\Domain\Audio\VO\Path;

final class Translate
{
    public function __construct(
        public readonly Identifier $language,
        public readonly Description $description,
        public readonly Path $path
    ) {
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getLanguage(): Identifier
    {
        return $this->language;
    }

    public function getPath(): Path
    {
        return $this->path;
    }
}
