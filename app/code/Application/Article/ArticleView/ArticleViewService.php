<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleView;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\Article\ArticleView\View\ArticleViewDTO;
use Romchik38\Site2\Application\Article\ArticleView\View\ArticleViewRepositoryInterface;

final class ArticleViewService
{
    public function __construct(
        protected readonly ArticleViewRepositoryInterface $articleViewRepository
    ) {
    }

    /** @return ArticleViewDTO Active article by provided language */
    public function getArticle(Find $command): ArticleViewDTO
    {
        return $this->articleViewRepository->getByIdAndLanguage($command);
    }

    /**
     * all active article ids
     *
     * @return string[]
     */
    public function listIds(): array
    {
        return $this->articleViewRepository->listIds();
    }

    /**
     * @return array<int,ArticleIdNameDTO> all active article ids and names
     */
    public function listIdsNames(string $language): array
    {
        return $this->articleViewRepository->listIdName($language);
    }

    /**
     * @throws NoSuchEntityException
     * @return string Article name
     */
    public function getArticleName(Find $command): string
    {
        $article = $this->getArticle($command);
        return $article->name;
    }
}
