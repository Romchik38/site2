<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminView\View;

use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier;

final readonly class Translate
{
    public function __construct(
        public Identifier $language,
        public Description $description,
        public Path $path
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
