<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Utils\Article;

use DateTime;
use Romchik38\Site2\Application\Article\List\Commands\Filter\DateFormatterInterface;

use function date_format;

final class DateFormatterUsesDateFormat implements DateFormatterInterface
{
    public function formatByString(DateTime $date, string $format): string
    {
        return date_format($date, $format);
    }
}
