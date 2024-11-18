<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Application\ArticleListView\View\ArticleDTO;
use Romchik38\Site2\Application\ArticleListView\View\ArticleDTOFactory;
use Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface;
use Romchik38\Site2\Application\ArticleListView\View\SearchCriteriaInterface;

final class ArticleListViewRepository implements ArticleListViewRepositoryInterface
{

    public function __construct(
        protected DatabaseInterface $database,
        protected ArticleDTOFactory $articleDTOFactory
    ) {}

    public function list(SearchCriteriaInterface $searchCriteria): array
    {
        $expression = [];
        $params = [$searchCriteria->language()];
        $paramCount = 1;

        /** ORDER BY */
        $orderBy = $searchCriteria->orderBy();

        $expression[] = sprintf(
            'ORDER BY %s %s %s',
            $orderBy->getField(),
            $orderBy->getDirection(),
            $orderBy->getNulls()
        );

        /** LIMIT */
        $limit = $searchCriteria->limit();
        $expression[] = sprintf('LIMIT $%s', ++$paramCount);
        $params[] = $limit->toString();

        /** OFFSET */
        $offset = $searchCriteria->offset();
        $expression[] = sprintf('OFFSET $%s', ++$paramCount);
        $params[] = $offset->toString();

        $rows = $this->listRows(
            $this->defaultQuery(),
            implode(' ', $expression),
            $params
        );

        $models = [];

        foreach ($rows as $row) {
            $models[] = $this->createFromRow($row);
        }
        return $models;
    }

    public function totalCount(): int
    {
        $query = <<<QUERY
        SELECT count(article.identifier) as count 
        FROM article 
        WHERE article.active = 'true'
        QUERY;

        $rows = $this->database->queryParams($query, []);

        $firstElem = $rows[0];
        $count = $firstElem['count'];

        return (int)$count;
    }

    /**
     * SELECT
     * used to select rows from all tables by given expression
     * @param array<int,string> $params
     * @return array<int,array<string,string>>
     */
    protected function listRows(
        string $queryBody,
        string $expression,
        array $params
    ): array {

        $query = sprintf('%s %s', $queryBody, $expression);

        $rows = $this->database->queryParams($query, $params);

        return $rows;
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): ArticleDTO
    {
        $articleDTO = $this->articleDTOFactory->create(
            $row['identifier'],
            $row['name'],
            $row['short_description'],
            $row['description'],
            $row['created_at'],
            json_decode($row['category']),
        );

        return $articleDTO;
    }

    protected function defaultQuery(): string
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
            article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = $1
        QUERY;
    }
}
