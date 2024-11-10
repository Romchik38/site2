<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView;

use Romchik38\Server\Models\Errors\EntityLogicException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\ArticleListView\View\ArticleDTO;
use Romchik38\Site2\Application\ArticleListView\View\ArticleDTOFactory;
use Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\ArticleRepositoryInterface;
use Romchik38\Site2\Domain\Article\ArticleTranslates;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Application\ArticleListView\View\SearchCriteriaFactoryInterface;

/** @todo refactor - create own repo and view model */
final class ArticleListViewService
{

    public function __construct(
        private readonly ArticleRepositoryInterface $articleRepository,
        private readonly ArticleDTOFactory $articleDTOFactory,
        private readonly ArticleListViewRepositoryInterface $articleListViewRepository,
        private readonly SearchCriteriaFactoryInterface $searchCriteriaFactory
    ) {}

    /** 
     * @todo delete this when list method will be ready
     * @throws NoSuchEntityException on missing id
     * @throws EntityLogicException on missing translate
    */
    public function getByIdAndLanguage(ArticleId $id, string $language): ArticleDTO
    {
        $article = $this->articleRepository->getById($id);
        $translate = $article->getTranslate($language);
        $articleDTO = $this->mapArticleToDTO($article, $translate);
        return $articleDTO;
    }

    public function list(Pagination $command, string $language): array {

        $searchCriteria = $this->searchCriteriaFactory->create(
            $command->offset(),
            $command->limit(),
            $command->orderByField(),
            $command->orderByDirection(),
            $language
        );

        $models = $this->articleListViewRepository->list($searchCriteria);
        
        return [];
    }

    /** 
     * @param Article $article
     * @return ArticleDTO
     */
    protected function mapArticleToDTO(Article $article, ArticleTranslates $translate): ArticleDTO
    {
        /** $todo replace with cat mapper */
        $f = fn($c) => $c->getCategoryId();
        $categories = $article->getAllCategories();
        $articleDTO = $this->articleDTOFactory->create(
            $article->getId()->toString(),
            $article->getActive(),
            $translate->getName(),
            $translate->getShortDescription(),
            $translate->getDescription(),
            $translate->getCreatedAt(),
            $translate->getUpdatedAt(),
            array_map($f, $categories),
            $translate->getReadLength()
        );

        return $articleDTO;
    }
}
