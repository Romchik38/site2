<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView\View;

interface ReadLengthFormatterInterface
{
    /** creates formatted string by given minutes */
    public function formatByMinutes(int $minutes): string;
}
