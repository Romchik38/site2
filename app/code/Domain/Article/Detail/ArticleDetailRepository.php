<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Detail;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Domain\Api\Article\ArticleRepositoryInterface;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\ArticleTranslates;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Models\DTO\Article\ArticleDTO;
use Romchik38\Site2\Models\DTO\Article\ArticleDTOFactory;

final class ArticleDetailRepository
{

    public function __construct(
        private readonly ArticleRepositoryInterface $articleRepository,
        private readonly ArticleDTOFactory $articleDTOFactory
    ) {}

    /** @throws NoSuchEntityException */
    public function getByIdAndLanguages(ArticleId $id, array $languages): ArticleDTO
    {
        $article = $this->articleRepository->getById($id);
        $translate = $this->getTranslate($article, $languages);
        $articleDTO = $this->mapArticleToDTO($article, $translate);
        return $articleDTO;
    }

    /** @param string[] $languages */
    protected function getTranslate(Article $article, array $languages): ArticleTranslates
    {

        foreach ($languages as $language) {
            $translate = $article->getTranslate($language);
            if ($translate !== null) {
                return $translate;
            }
        }

        throw new ArticleDetailProcessException(
            sprintf(
                'Translate for article %s is missing',
                $article->getId()->toString()
            )
        );
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
