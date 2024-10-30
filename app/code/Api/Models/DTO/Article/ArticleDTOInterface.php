<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\DTO\Article;

interface ArticleDTOInterface
{
    public function getId(): string;
    public function getActive(): bool;
    public function getName(): string;
    public function getShortDescription(): string;
    public function getDescription(): string;
    public function getCreatedAt(): \DateTime;
    public function getUpdatedAt(): \DateTime;

    /** @return string[] A list with categories ids */
    public function getCategories(): array;
}
