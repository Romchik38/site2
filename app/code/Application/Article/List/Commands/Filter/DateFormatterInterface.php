<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List\Commands\Filter;

use DateTime;

/** @todo remove when unused */
interface DateFormatterInterface
{
    /**
     * formats given date and returns string representation
     */
    public function formatByString(DateTime $date, string $format): string;
}
