<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services;

use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Site2\Api\Services\ReadLengthFormatterInterface;

final class ReadLengthFormatter implements ReadLengthFormatterInterface
{

    public function __construct(
        protected readonly TranslateInterface $translate
    ) {}

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

        $hours = (int)($minutes / 60);

        if ($hours < 24) {
            return sprintf(
                '%s %s',
                $hours,
                $this->translate->t('read-length-formatter.hour')
            );
        }

        $days = (int)($hours / 24);

        return sprintf(
            '%s %s',
            $days,
            $this->translate->t('read-length-formatter.day')
        );
    }
}
