<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Article;

use Romchik38\Server\Models\Errors\EntityLogicException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\ArticleList\View\ArticleViewRepositoryInterface;
use Romchik38\Site2\Domain\Api\Article\ArticleRepositoryInterface;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\ArticleTranslates;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

/** @todo Create and interface */
final class ArticleViewRepository implements ArticleViewRepositoryInterface
{

    public function __construct(
        private readonly ArticleRepositoryInterface $articleRepository,
        private readonly ArticleDTOFactory $articleDTOFactory
    ) {}

    /** 
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
