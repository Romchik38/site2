<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Entities;

use DateTime;
use InvalidArgumentException;

use function count;
use function explode;
use function round;
use function strlen;

final class Translate
{
    public function __construct(
        private string $language,
        private string $name,
        private string $shortDescription,
        private string $description,
        private DateTime $createdAt,
        private DateTime $updatedAt
    ) {
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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /** @throws InvalidArgumentException - When string is empty. */
    public function setLanguage(string $language): self
    {
        if (strlen($language) === 0) {
            throw new InvalidArgumentException('Article language field can\'t be empty');
        }

        $this->language = $language;
        return $this;
    }

    /** @throws InvalidArgumentException - When string is empty. */
    public function setName(string $name): self
    {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('Article name field can\'t be empty');
        }

        $this->name = $name;
        return $this;
    }

    /** @throws InvalidArgumentException - When string is empty. */
    public function setShortDescription(string $shortDescription): self
    {
        if (strlen($shortDescription) === 0) {
            throw new InvalidArgumentException('Article short description field can\'t be empty');
        }

        $this->shortDescription = $shortDescription;
        return $this;
    }

    /** @throws InvalidArgumentException - When string is empty. */
    public function setDescription(string $description): self
    {
        if (strlen($description) === 0) {
            throw new InvalidArgumentException('Article description field can\'t be empty');
        }

        $this->description = $description;
        return $this;
    }

    public function setCreatedAt(DateTime $date): self
    {
        $this->createdAt = $date;
        return $this;
    }

    public function setUpdatedAt(DateTime $date): self
    {
        $this->updatedAt = $date;
        return $this;
    }

    /**
     * @throws InvalidArgumentException $speed - Must be greater than 0.
     * @param int $speed words/minute
     * @return int Minutes to read
     */
    public function getReadLength(int $speed = 200): int
    {
        if ($speed < 1) {
            throw new InvalidArgumentException('param $speed must be greater than 0');
        }

        $description = $this->getDescription();

        $words = count(explode(' ', $description));
        return (int) round($words / $speed);
    }
}
