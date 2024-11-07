<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView\View;

interface DateFormatterInterface
{
    /**
     * formats given date and returns string representation
     */
    public function formatByString(\DateTime $date, string $format): string;
}
