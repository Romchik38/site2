<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Virtual\Article;

use Romchik38\Server\Api\Models\ModelInterface;

/**
 * Article entity 
 * @api
 */
interface ArticleInterface extends ModelInterface
{
    final const ID_FIELD = 'identifier';
    final const ACTIVE_FIELD = 'active';
    final const CATEGORY_ID_FIELD = 'category_id';

    public function getId(): string;
    public function getActive(): bool;

    /** @return string[] a list of categories ids*/
    public function getCategory_id(): array;

    /** @throws InvalidArgumentException when string is empty */
    public function setId(string $id): ArticleInterface;

    public function setActive(bool $active): ArticleInterface;

    /** @param string[] $category a list of categories ids*/
    public function setCategory_id(array $category): ArticleInterface;
}
