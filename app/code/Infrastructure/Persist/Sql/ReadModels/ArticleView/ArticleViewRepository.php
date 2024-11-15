<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleView;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Errors\RepositoryConsistencyException;
use Romchik38\Site2\Application\ArticleView\View\ArticleViewDTO;
use Romchik38\Site2\Application\ArticleView\View\ArticleViewDTOFactory;
use Romchik38\Site2\Application\ArticleView\View\ArticleViewRepositoryInterface;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

final class ArticleViewRepository implements ArticleViewRepositoryInterface
{

    public function __construct(
        protected DatabaseInterface $database,
        protected ArticleViewDTOFactory $factory
    ) {}

    public function getByIdAndLanguage(ArticleId $id, string $language): ArticleViewDTO
    {
        $articleId = $id->toString();
        $params = [$language, $articleId];

        $rows = $this->database->queryParams($this->getByIdQuery(), $params);

        if (count($rows) === 0) {
            throw new NoSuchEntityException(sprintf(
                'Article with id %s not found',
                $articleId
            ));
        } elseif (count($rows) > 1) {
            throw new RepositoryConsistencyException(sprintf(
                'Article with id %s has duplicate',
                $articleId
            ));
        }

        $row = $rows[0];

        return $this->createFromRow($row);
    }

    protected function createFromRow(array $row): ArticleViewDTO
    {
        $articleViewDTO = $this->factory->create(
            $row['identifier'],
            $row['name'],
            $row['short_description'],
            $row['description'],
            json_decode($row['category']),
            $row['created_at'],
            $row['updated_at']
        );

        return $articleViewDTO;
    }


    protected function getByIdQuery(): string
    {
        return <<<QUERY
        WITH categories AS
        (
            SELECT category_translates.category_id,
                category_translates.name
            FROM category_translates
            WHERE category_translates.language = $1
        ) 
        SELECT article.identifier,
        article_translates.name,
        article_translates.short_description,
        article_translates.description,
        article_translates.created_at,
        article_translates.updated_at,
        array_to_json (
            array (
                select
                    categories.name
                from
                    categories, article_category
                where
                    article.identifier = article_category.article_id AND
                    categories.category_id = article_category.category_id
            )
        ) as category 
        FROM
            article,
            article_translates
        WHERE 
            article.identifier = $2
            AND article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = $1
        QUERY;
    }
}
