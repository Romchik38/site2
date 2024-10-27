<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\ArticleTranslates;

use InvalidArgumentException;
use Romchik38\Server\Models\Model;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;

final class ArticleTranslates extends Model implements ArticleTranslatesInterface {

    public function getArticleId(): string {
        return (string)$this->getData($this::ARTICLE_ID_FIELD);
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
        return new \DateTime((string)$this->getData($this::CREATED_AT_FIELD));
    }

    public function getUpdatedAt(): \DateTime
    {
        return new \DateTime((string)$this->getData($this::UPDATED_AT_FIELD));
    }


    public function setArticleId(string $id): ArticleTranslatesInterface {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }

        $this->setData($this::ARTICLE_ID_FIELD, $id);
        return $this;
    }

    public function setLanguage(string $language): ArticleTranslatesInterface
    {
        if (strlen($language) === 0) {
            throw new InvalidArgumentException('Article language field can\'t be empty');
        }

        $this->setData($this::LANGUAGE_FIELD, $language);
        return $this;
    }

    public function setName(string $name): ArticleTranslatesInterface
    {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('Article name field can\'t be empty');
        }

        $this->setData($this::NAME_FIELD, $name);
        return $this;
    }

    public function setDescription(string $description): ArticleTranslatesInterface
    {
        if (strlen($description) === 0) {
            throw new InvalidArgumentException('Article description field can\'t be empty');
        }

        $this->setData($this::DESCRIPTION_FIELD, $description);
        return $this;
    }

    public function setCreatedAt(\DateTime $date): ArticleTranslatesInterface
    {
        $this->setData($this::CREATED_AT_FIELD, $date);
        return $this;
    }

    public function setUpdatedAt(\Datetime $date): ArticleTranslatesInterface
    {
        $this->setData($this::UPDATED_AT_FIELD, $date);
        return $this;
    }

}
