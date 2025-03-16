<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleListView\View;

final class ArticleDTOFactory
{
    protected const DATE_FORMAT_CATEGORY_PAGE = 'j-n-y';
    protected const int READING_SPEED = 200;

    public function __construct(
        protected readonly DateFormatterInterface $dateFormatter,
        protected readonly ReadLengthFormatterInterface $readLengthFormatter
    ) {}

    /** @param string[] $categories */
    public function create(
        string $articleId,
        string $name,
        string $shortDescription,
        string $description,
        string $createdAt,
        array $categories,
        ImageDTO $image
    ): ArticleDTO {

        $formattedCreatedAt = $this->dateFormatter->formatByString(
            new \DateTime($createdAt),
            $this::DATE_FORMAT_CATEGORY_PAGE
        );

        $words = count(explode(' ', $description));
        $minutesToRead = (int)round(($words / $this::READING_SPEED));
        $readLength = $this->readLengthFormatter->formatByMinutes($minutesToRead);

        return new ArticleDTO(
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
