<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleList\View;

interface ReadLengthFormatterInterface
{
    /** creates formatted string by given minutes */
    public function formatByMinutes(int $minutes): string;
}
