<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleView;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\ArticleView\View\ArticleIdNameDTO;
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
        return $this->articleViewRepository->getByIdAndLanguage($command);
    }

    /** all active article ids */
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
