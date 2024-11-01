<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\ArticleTranslates;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;

final class ArticleTranslates implements ArticleTranslatesInterface
{

    public function __construct(
        protected string $articleId,
        protected string $language,
        protected string $name,
        protected string $shortDescription,
        protected string $description,
        protected \DateTime $createdAt,
        protected \DateTime $updatedAt
    ) {}

    public function getArticleId(): string
    {
        return $this->articleId;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }


    public function setArticleId(string $id): ArticleTranslatesInterface
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }
        $this->articleId = $id;
        return $this;
    }

    public function setLanguage(string $language): ArticleTranslatesInterface
    {
        if (strlen($language) === 0) {
            throw new InvalidArgumentException('Article language field can\'t be empty');
        }

        $this->language = $language;
        return $this;
    }

    public function setName(string $name): ArticleTranslatesInterface
    {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('Article name field can\'t be empty');
        }

        $this->name = $name;
        return $this;
    }

    public function setShortDescription(string $shortDescription): ArticleTranslatesInterface
    {
        if (strlen($shortDescription) === 0) {
            throw new InvalidArgumentException('Article short description field can\'t be empty');
        }

        $this->shortDescription = $shortDescription;
        return $this;
    }

    public function setDescription(string $description): ArticleTranslatesInterface
    {
        if (strlen($description) === 0) {
            throw new InvalidArgumentException('Article description field can\'t be empty');
        }

        $this->description = $description;
        return $this;
    }

    public function setCreatedAt(\DateTime $date): ArticleTranslatesInterface
    {
        $this->createdAt = $date;
        return $this;
    }

    public function setUpdatedAt(\Datetime $date): ArticleTranslatesInterface
    {
        $this->updatedAt = $date;
        return $this;
    }

    public function getReadLength(int $speed = 200): int {
        if ($speed < 1) {
            throw new InvalidArgumentException('param $speed must be greater than 0');
        }

        $description = $this->getDescription();

        $words = count(explode(' ', $description));
        $timeToRead = (int)round(($words / $speed));
        return $timeToRead;   
    }

}
