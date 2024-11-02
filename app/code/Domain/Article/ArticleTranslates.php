<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class ArticleTranslates
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

    /** @throws InvalidArgumentException when string is empty */
    public function setArticleId(string $id): self
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }
        $this->articleId = $id;
        return $this;
    }

    /** @throws InvalidArgumentException when string is empty */
    public function setLanguage(string $language): self
    {
        if (strlen($language) === 0) {
            throw new InvalidArgumentException('Article language field can\'t be empty');
        }

        $this->language = $language;
        return $this;
    }

    /** @throws InvalidArgumentException when string is empty */
    public function setName(string $name): self
    {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('Article name field can\'t be empty');
        }

        $this->name = $name;
        return $this;
    }

    /** @throws InvalidArgumentException when string is empty */    
    public function setShortDescription(string $shortDescription): self
    {
        if (strlen($shortDescription) === 0) {
            throw new InvalidArgumentException('Article short description field can\'t be empty');
        }

        $this->shortDescription = $shortDescription;
        return $this;
    }

    /** @throws InvalidArgumentException when string is empty */    
    public function setDescription(string $description): self
    {
        if (strlen($description) === 0) {
            throw new InvalidArgumentException('Article description field can\'t be empty');
        }

        $this->description = $description;
        return $this;
    }

    public function setCreatedAt(\DateTime $date): self
    {
        $this->createdAt = $date;
        return $this;
    }

    public function setUpdatedAt(\Datetime $date): self
    {
        $this->updatedAt = $date;
        return $this;
    }

     /**
     * @throws InvalidArgumentException $speed must be greater than 0
     * @param int $speed words/minute 
     * @return int Minutes to read
     */
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
