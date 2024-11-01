<?php

declare(strict_types=1);

namespace Romchik38\Site2\Services;

use Romchik38\Site2\Api\Services\ReadLengthFormatterInterface;

final class ReadLengthFormatter implements ReadLengthFormatterInterface {

    public function formatByMinutes(int $minutes): string
    {
        if ($minutes < 10) {
            return sprintf('a few minutes');
        }

        if ($minutes < 60) {
            return sprintf('% min', $minutes);
        }

        $hours = (int)($minutes/60);

        if ($hours < 24) {
            return sprintf('% hours', $hours);
        }

        $days = (int)($hours/24);

        return sprintf('% days', $days);
    }
}