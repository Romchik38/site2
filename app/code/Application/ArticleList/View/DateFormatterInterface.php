<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Services;

interface DateFormatterInterface
{
    /**
     * makes a string presentation of the given date 
     */
    public function formatByString(\DateTime $date, string $format): string;
}
