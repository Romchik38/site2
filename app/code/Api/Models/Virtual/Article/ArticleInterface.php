<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Virtual\Article;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site2\Api\Models\ArticleCategory\ArticleCategoryInterface;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;

/**
 * Article entity 
 * @api
 */
interface ArticleInterface
{
    final const ENTITY_NAME = 'article';
    
    final const ID_FIELD = 'identifier';
    final const ACTIVE_FIELD = 'active';

    /** Persistant data */
    public function getId(): string;
    public function getActive(): bool;

    /** @throws InvalidArgumentException when string is empty */
    public function setId(string $id): ArticleInterface;

    public function setActive(bool $active): ArticleInterface;

    /** Models */
    public function getTranslate(string $language): ArticleTranslatesInterface|null;
    public function getCategory(string $categoryId): ArticleCategoryInterface|null;
    
    /** Additional */
    /** @return ArticleCategoryInterface[] */
    public function getAllCategories(): array;

}
