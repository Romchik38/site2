<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\DTO\Article;

interface ArticleDTOFactoryInterface
{
    /** @param string[] $categories a list of categories ids*/
    public function create(
        string $articleId,
        bool $active,
        string $name,
        string $shortDescription,
        string $description,
        \DateTime $createdAt,
        \DateTime $updatedAt,
        array $categories,
        int $minutesToRead
    ): ArticleDTOInterface;
}
