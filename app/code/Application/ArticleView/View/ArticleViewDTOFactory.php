<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleView\View;

use Romchik38\Site2\Application\ArticleListView\View\DateFormatterInterface;

final class ArticleViewDTOFactory
{
    protected const DATE_FORMAT_CATEGORY_PAGE = 'j-n-y';

    public function __construct(
        protected readonly DateFormatterInterface $dateFormatter
    ) {}

    public function create(
        string $articleId,
        string $name,
        string $shortDescription,
        string $description,
        array $categories,
        string $createdAt
    ): ArticleViewDTO {

        $formattedCreatedAt = $this->dateFormatter->formatByString(
            new \DateTime($createdAt),
            $this::DATE_FORMAT_CATEGORY_PAGE
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
