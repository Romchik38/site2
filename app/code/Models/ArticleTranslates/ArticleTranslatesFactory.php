<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\ArticleTranslates;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesFactoryInterface;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;

final class ArticleTranslatesFactory implements ArticleTranslatesFactoryInterface
{
    
    public function create(
        string $articleId,
        string $language,
        string $name,
        string $shortDescription,
        string $description,
        \DateTime $createdAt,
        \DateTime $updatedAt
    ): ArticleTranslatesInterface {

        if (strlen($articleId) === 0 || 
            strlen($language) === 0 ||
            strlen($name) === 0 ||
            strlen($shortDescription) === 0 ||
            strlen($description) === 0
        ) {
            throw new InvalidArgumentException('ArticleTranslates params can\'t be empty');
        }

        return new ArticleTranslates(
            $articleId,
            $language,
            $name,
            $shortDescription,
            $description,
            $createdAt,
            $updatedAt
        );
    }
}
