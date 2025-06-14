<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View\View;

use DateTime;

use function count;
use function explode;
use function round;

final class ArticleDtoFactory
{
    private const DATE_FORMAT_CATEGORY_PAGE = 'j-n-y';
    private const int READING_SPEED         = 200;

    public function __construct(
        private readonly DateFormatterInterface $dateFormatter,
        private readonly ReadLengthFormatterInterface $readLengthFormatter
    ) {
    }

    /** @param string[] $categories */
    public function create(
        string $articleId,
        string $name,
        string $shortDescription,
        string $description,
        string $createdAt,
        array $categories,
        ImageDto $image
    ): ArticleDto {
        $formattedCreatedAt = $this->dateFormatter->formatByString(
            new DateTime($createdAt),
            $this::DATE_FORMAT_CATEGORY_PAGE
        );

        $words         = count(explode(' ', $description));
        $minutesToRead = (int) round($words / $this::READING_SPEED);
        $readLength    = $this->readLengthFormatter->formatByMinutes($minutesToRead);

        return new ArticleDto(
            $articleId,
            $name,
            $shortDescription,
            $categories,
            $formattedCreatedAt,
            $readLength,
            $image
        );
    }
}
