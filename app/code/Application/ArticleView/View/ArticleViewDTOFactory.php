<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleView\View;

use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Site2\Application\ArticleListView\View\DateFormatterInterface;

final class ArticleViewDTOFactory
{
    protected const DATE_FORMAT_DAY = 'j';
    protected const DATE_FORMAT_MONTH = 'F';
    protected const DATE_FORMAT_YEAR_TIME = 'y G:i';

    public function __construct(
        protected readonly DateFormatterInterface $dateFormatter,
        protected readonly TranslateInterface $translate
    ) {}

    /** @param string[] $categories */
    public function create(
        string $articleId,
        string $name,
        string $shortDescription,
        string $description,
        array $categories,
        string $createdAt
    ): ArticleViewDTO {

        $date = new \DateTime($createdAt);

        $formattedDay = $this->dateFormatter->formatByString(
            $date,
            $this::DATE_FORMAT_DAY
        );

        $formattedMonth = $this->dateFormatter->formatByString(
            $date,
            $this::DATE_FORMAT_MONTH
        );

        $formattedYearTime = $this->dateFormatter->formatByString(
            $date,
            $this::DATE_FORMAT_YEAR_TIME
        );

        $formattedCreatedAt = sprintf(
            '%s %s %s',
            $formattedDay,
            $this->translate->t('article.view.month.' . $formattedMonth),
            $formattedYearTime
        );

        return new ArticleViewDTO(
            $articleId,
            $name,
            $shortDescription,
            $description,
            $categories,
            $formattedCreatedAt
        );
    }
}
