<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleView\View;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

interface ArticleViewRepositoryInterface
{
    /** @throws NoSuchEntityException */
    public function getByIdAndLanguage(ArticleId $id, string $language): ArticleViewDTO;

    /** all active article ids */
    public function listIds(): array;
}
