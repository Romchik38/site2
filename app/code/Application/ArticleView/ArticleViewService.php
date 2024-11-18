<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleView;

use Romchik38\Site2\Application\ArticleView\View\ArticleViewDTO;
use Romchik38\Site2\Application\ArticleView\View\ArticleViewRepositoryInterface;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

final class ArticleViewService
{

    public function __construct(
        protected readonly ArticleViewRepositoryInterface $articleViewRepository
    ) {}

    /** @return ArticleViewDTO Active article by provided language */
    public function getArticle(Find $command): ArticleViewDTO
    {
        return $this->articleViewRepository->getByIdAndLanguage(
            new ArticleId($command->id()),
            $command->language()
        );
    }

    /** all active article ids */
    public function listIds(): array
    {
        return $this->articleViewRepository->listIds();
    }

    /** all active article ids and names 
     * @return array<int,ArticleIdNameDTO>
    */
    public function listIdsNames(string $language): array
    {
        return $this->articleViewRepository->listIdName($language);
    }
}
