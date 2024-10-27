<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article;

use DateTime;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Model;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;

final class Article extends Model implements ArticleInterface
{

    public function getId(): string
    {
        return (string)$this->getData($this::ID_FIELD);
    }

    public function getActive(): bool
    {
        return (bool)$this->getData($this::ACTIVE_FIELD);
    }

    /** @return string[] a list of categories ids*/
    public function getCategory_id(): array
    {
        $category = $this->getData($this::CATEGORY_ID_FIELD) ?? [];
        return $category;
    }

    public function setId(string $id): ArticleInterface
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }

        $this->setData($this::ID_FIELD, $id);
        return $this;
    }

    public function setActive(bool $active): ArticleInterface
    {
        $this->setData($this::ACTIVE_FIELD, $active);
        return $this;
    }

    /** @param string[] $category a list of categories ids*/
    public function setCategory_id(array $category): ArticleInterface
    {
        $this->setData($this::CATEGORY_ID_FIELD, $category);
        return $this;
    }
}
