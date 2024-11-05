<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleList\View;

interface DateFormatterInterface
{
    /**
     * makes a string presentation of the given date 
     */
    public function formatByString(\DateTime $date, string $format): string;
}
