<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleList\View;

use DateTime;
use Romchik38\Site2\Api\Services\DateFormatterInterface;
use Romchik38\Site2\Api\Services\ReadLengthFormatterInterface;

final class ArticleDTOFactory
{

    public function __construct(
        protected readonly DateFormatterInterface $dateFormatter,
        protected readonly ReadLengthFormatterInterface $readLengthFormatter
    ) {}

    public function create(
        string $articleId,
        bool $active,
        string $name,
        string $shortDescription,
        string $description,
        DateTime $createdAt,
        DateTime $updatedAt,
        array $categories,
        int $minutesToRead
    ): ArticleDTO {
        return new ArticleDTO(
            $articleId,
            $active,
            $name,
            $shortDescription,
            $description,
            $createdAt,
            $updatedAt,
            $categories,
            $minutesToRead,
            $this->dateFormatter,
            $this->readLengthFormatter
        );
    }
}
