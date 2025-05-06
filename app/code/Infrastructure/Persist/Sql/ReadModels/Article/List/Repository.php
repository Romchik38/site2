<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\List;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\ArticleDTO;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\ArticleDTOFactory;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\ImageDTOFactory;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\SearchCriteria;
use Romchik38\Site2\Application\Article\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\List\RepositoryInterface;

use function implode;
use function json_decode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private DatabaseSqlInterface $database,
        private ArticleDTOFactory $articleDtoFactory,
        private ImageDTOFactory $imageDtoFactory
    ) {
    }

    public function list(SearchCriteria $searchCriteria): array
    {
        $expression = [];
        $params     = [$searchCriteria->language];
        $paramCount = 1;

        /** ORDER BY */
        try {
            $orderBy = new OrderBy(
                ($searchCriteria->orderByField)(),
                ($searchCriteria->orderByDirection)()
            );
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $expression[] = sprintf(
            'ORDER BY %s %s %s',
            $orderBy->getField(),
            $orderBy->getDirection(),
            $orderBy->getNulls()
        );

        /** LIMIT */
        $expression[] = sprintf('LIMIT $%s', ++$paramCount);
        $params[]     = ($searchCriteria->limit)();

        /** OFFSET */
        $expression[] = sprintf('OFFSET $%s', ++$paramCount);
        $params[]     = (string) $searchCriteria->offset;

        $query = sprintf(
            '%s %s',
            $this->defaultQuery(),
            implode(' ', $expression)
        );

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

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

        try {
            $rows = $this->database->queryParams($query, []);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $firstElem = $rows[0];
        $count     = $firstElem['count'];

        return (int) $count;
    }

    /**
     * @throws RepositoryException
     * @param array<string,string> $row
     * */
    private function createFromRow(array $row): ArticleDTO
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Article id is invalid');
        }
        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Article name is invalid');
        }
        $rawShortDescription = $row['short_description'] ?? null;
        if ($rawShortDescription === null) {
            throw new RepositoryException('Article short description is invalid');
        }
        $rawDescription = $row['description'] ?? null;
        if ($rawDescription === null) {
            throw new RepositoryException('Article description is invalid');
        }
        $rawCreatedAt = $row['created_at'] ?? null;
        if ($rawCreatedAt === null) {
            throw new RepositoryException('Article created at is invalid');
        }
        $rawCategory = $row['category'] ?? null;
        if ($rawCategory === null) {
            throw new RepositoryException('Article category at is invalid');
        }
        $rawImgId = $row['img_id'] ?? null;
        if ($rawImgId === null) {
            throw new RepositoryException('Article img id at is invalid');
        }
        $rawImgPath = $row['img_path'] ?? null;
        if ($rawImgPath === null) {
            throw new RepositoryException('Article img path at is invalid');
        }
        $rawImgDescription = $row['img_description'] ?? null;
        if ($rawImgDescription === null) {
            throw new RepositoryException('Article img description at is invalid');
        }

        return $this->articleDtoFactory->create(
            $rawIdentifier,
            $rawName,
            $rawShortDescription,
            $rawDescription,
            $rawCreatedAt,
            json_decode($rawCategory),
            $this->imageDtoFactory->create($rawImgId, $rawImgPath, $rawImgDescription)
        );
    }

    private function defaultQuery(): string
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
