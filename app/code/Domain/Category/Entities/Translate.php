<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Category\Entities;

use Romchik38\Site2\Domain\Category\VO\Description;
use Romchik38\Site2\Domain\Category\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier;

final class Translate
{
    public function __construct(
        public readonly Identifier $language,
        public Description $description,
        public Name $name
    ) {
    }

    public function changeDescription(Description $description): void
    {
        $this->description = $description;
    }

    public function reName(Name $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getLanguage(): Identifier
    {
        return $this->language;
    }

    public function getName(): Name
    {
        return $this->name;
    }
}
