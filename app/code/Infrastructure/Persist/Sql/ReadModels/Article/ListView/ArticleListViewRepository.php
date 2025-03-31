<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\ListView;

use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Article\ArticleListView\View\ArticleDTO;
use Romchik38\Site2\Application\Article\ArticleListView\View\ArticleDTOFactory;
use Romchik38\Site2\Application\Article\ArticleListView\View\ArticleListViewRepositoryInterface;
use Romchik38\Site2\Application\Article\ArticleListView\View\ImageDTOFactory;
use Romchik38\Site2\Application\Article\ArticleListView\View\SearchCriteriaInterface;

use function implode;
use function json_decode;
use function sprintf;

final class ArticleListViewRepository implements ArticleListViewRepositoryInterface
{
    public function __construct(
        protected DatabaseSqlInterface $database,
        protected ArticleDTOFactory $articleDtoFactory,
        protected ImageDTOFactory $imageDtoFactory
    ) {
    }

    public function list(SearchCriteriaInterface $searchCriteria): array
    {
        $expression = [];
        $params     = [$searchCriteria->language()];
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
        $limit        = $searchCriteria->limit();
        $expression[] = sprintf('LIMIT $%s', ++$paramCount);
        $params[]     = $limit();

    /** OFFSET */
        $offset       = $searchCriteria->offset();
        $expression[] = sprintf('OFFSET $%s', ++$paramCount);
        $params[]     = $offset->toString();

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
        $count     = $firstElem['count'];

        return (int) $count;
    }

    /**
     * SELECT
     * used to select rows from all tables by given expression
     *
     * @param array<int,string> $params
     * @return array<int,array<string,string>>
     */
    protected function listRows(
        string $queryBody,
        string $expression,
        array $params
    ): array {
        $query = sprintf('%s %s', $queryBody, $expression);

        return $this->database->queryParams($query, $params);
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): ArticleDTO
    {
        return $this->articleDtoFactory->create(
            $row['identifier'],
            $row['name'],
            $row['short_description'],
            $row['description'],
            $row['created_at'],
            json_decode($row['category']),
            $this->imageDtoFactory->create(
                $row['img_id'],
                $row['img_path'],
                $row['img_description']
            )
        );
    }

    protected function defaultQuery(): string
    {
        return <<<'QUERY'
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
        ) as category,
        img.path as img_path,
        img_translates.img_id,
        img_translates.description as img_description
        FROM
            article,
            article_translates,
            img,
            img_translates
        WHERE 
            article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = $1
            AND article.img_id = img.identifier
            AND img_translates.img_id = article.img_id
            AND img_translates.language = $1
        QUERY;
    }
}
