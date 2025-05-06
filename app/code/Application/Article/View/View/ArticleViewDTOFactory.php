<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\View\View;

use DateTime;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\DateFormatterInterface;

use function sprintf;

final class ArticleViewDTOFactory
{
    private const DATE_FORMAT_DAY       = 'j';
    private const DATE_FORMAT_MONTH     = 'F';
    private const DATE_FORMAT_YEAR_TIME = 'y G:i';

    public function __construct(
        private readonly DateFormatterInterface $dateFormatter,
        private readonly TranslateInterface $translate
    ) {
    }

    /** @param string[] $categories */
    public function create(
        string $articleId,
        string $name,
        string $shortDescription,
        string $description,
        array $categories,
        string $createdAt,
        AuthorDTO $author,
        ImageDTO $image,
        AudioDTO $audio
    ): ArticleViewDTO {
        $date = new DateTime($createdAt);

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
            $formattedCreatedAt,
            $author,
            $image,
            $audio
        );
    }
}
