<?php

declare(strict_types=1);

namespace Romchik38\Site2\Services;

use Romchik38\Site2\Api\Services\DateFormatterInterface;

final class DateFormatterUsesDateFormat implements DateFormatterInterface
{
    public function formatByString(\DateTime $date, string $format): string
    {
        return date_format($date, $format);
    }
}
