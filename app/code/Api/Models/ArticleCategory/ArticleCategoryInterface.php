<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\ArticleCategory;

interface ArticleCategoryInterface {
    final const ENTITY_NAME = 'article_category';

    final const ARTICLE_ID_FIELD = 'article_id';
    final const CATEGORY_ID_FIELD = 'category_id';

    public function getArticleId(): string;
    public function getCategoryId(): string;

    /** @throws InvalidArgumentException when string is empty */
    public function setArticleId(string $id): ArticleCategoryInterface;
    
    /** @throws InvalidArgumentException when string is empty */
    public function setCategoryId(string $id): ArticleCategoryInterface;
}