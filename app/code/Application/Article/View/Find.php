<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\View;

final class Find
{
    public function __construct(
        protected readonly string $articleId,
        protected readonly string $language
    ) {
    }

    public function id(): string
    {
        return $this->articleId;
    }

    public function language(): string
    {
        return $this->language;
    }
}
