<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\DTO\Article;

use DateTime;
use Romchik38\Site2\Api\Models\DTO\Article\ArticleDTOFactoryInterface;
use Romchik38\Site2\Api\Models\DTO\Article\ArticleDTOInterface;
use Romchik38\Site2\Api\Services\DateFormatterInterface;

final class ArticleDTOFactory implements ArticleDTOFactoryInterface
{

    public function __construct(
        protected readonly DateFormatterInterface $dateFormatter
    ) {}

    public function create(
        string $articleId,
        bool $active,
        string $name,
        string $shortDescription,
        string $description,
        DateTime $createdAt,
        DateTime $updatedAt,
        array $categories
    ): ArticleDTOInterface {
        return new ArticleDTO(
            $articleId,
            $active,
            $name,
            $shortDescription,
            $description,
            $createdAt,
            $updatedAt,
            $categories,
            $this->dateFormatter
        );
    }
}
