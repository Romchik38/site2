<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\View;

use Romchik38\Site2\Application\Article\View\View\ArticleIdNameDTO;
use Romchik38\Site2\Application\Article\View\View\ArticleViewDTO;

final class ViewService
{
    public function __construct(
        private readonly RepositoryInterface $articleViewRepository
    ) {
    }

    /**
     * @throws NoSuchArticleException
     * @throws RepositoryException
     * @return ArticleViewDTO Active article by provided language
     * */
    public function getArticle(Find $command): ArticleViewDTO
    {
        return $this->articleViewRepository->getByIdAndLanguage($command);
    }

    /**
     * all active article ids
     *
     * @throws RepositoryException
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
     * @throws NoSuchArticleException
     * @throws RepositoryException
     * @return string Article name
     */
    public function getArticleName(Find $command): string
    {
        $article = $this->getArticle($command);
        return $article->name;
    }
}
