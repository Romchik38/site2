<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Utils;

use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\ReadLengthFormatterInterface;

use function sprintf;

final class ReadLengthFormatter implements ReadLengthFormatterInterface
{
    public function __construct(
        private readonly TranslateInterface $translate
    ) {
    }

    public function formatByMinutes(int $minutes): string
    {
        if ($minutes < 10) {
            return $this->translate->t('read-length-formatter.a-few-minutes');
        }

        if ($minutes < 60) {
            return sprintf(
                '%s %s',
                $minutes,
                $this->translate->t('read-length-formatter.min')
            );
        }

        $hours = (int) ($minutes / 60);

        if ($hours < 24) {
            return sprintf(
                '%s %s',
                $hours,
                $this->translate->t('read-length-formatter.hour')
            );
        }

        $days = (int) ($hours / 24);

        return sprintf(
            '%s %s',
            $days,
            $this->translate->t('read-length-formatter.day')
        );
    }
}
