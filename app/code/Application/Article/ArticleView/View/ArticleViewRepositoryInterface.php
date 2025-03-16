<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleView\View;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\Article\ArticleView\Find;

interface ArticleViewRepositoryInterface
{
    /** 
     * @throws NoSuchEntityException 
     * @throws RuntimeException - On duplicates.
    */
    public function getByIdAndLanguage(Find $command): ArticleViewDTO;

    /** 
     * all active article ids 
     * @return string[]
     */
    public function listIds(): array;

    /** @return array<int,ArticleIdNameDTO> */
    public function listIdName(string $language): array;
}
