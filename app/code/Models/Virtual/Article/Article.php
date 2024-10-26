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

    public function getLanguage(): string
    {
        return (string)$this->getData($this::LANGUAGE_FIELD);
    }

    public function getName(): string
    {
        return (string)$this->getData($this::NAME_FIELD);
    }

    public function getDescription(): string
    {
        return (string)$this->getData($this::DESCRIPTION_FIELD);
    }

    public function getCreatedAt(): \DateTime
    {
        return new DateTime((string)$this->getData($this::CREATED_AT_FIELD));
    }

    public function getUpdatedAt(): \DateTime
    {
        return new DateTime((string)$this->getData($this::UPDATED_AT_FIELD));
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

    public function setLanguage(string $language): ArticleInterface
    {
        if (strlen($language) === 0) {
            throw new InvalidArgumentException('Article language field can\'t be empty');
        }

        $this->setData($this::LANGUAGE_FIELD, $language);
        return $this;
    }

    public function setName(string $name): ArticleInterface
    {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('Article name field can\'t be empty');
        }

        $this->setData($this::NAME_FIELD, $name);
        return $this;
    }

    public function setDescription(string $description): ArticleInterface
    {
        if (strlen($description) === 0) {
            throw new InvalidArgumentException('Article description field can\'t be empty');
        }

        $this->setData($this::DESCRIPTION_FIELD, $description);
        return $this;
    }

    public function setCreatedAt(\DateTime $date): ArticleInterface
    {
        $this->setData($this::CREATED_AT_FIELD, $date);
        return $this;
    }

    public function setUpdatedAt(\Datetime $date): ArticleInterface
    {
        $this->setData($this::UPDATED_AT_FIELD, $date);
        return $this;
    }

    /** @param string[] $category a list of categories ids*/
    public function setCategory_id(array $category): ArticleInterface
    {
        $this->setData($this::CATEGORY_ID_FIELD, $category);
        return $this;
    }
}
