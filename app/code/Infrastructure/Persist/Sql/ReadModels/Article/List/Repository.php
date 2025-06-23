<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\List;

use DateTime;
use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Server\Persist\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Article\List\Commands\Filter\ArticleDTO;
use Romchik38\Site2\Application\Article\List\Commands\Filter\CategoryDTO;
use Romchik38\Site2\Application\Article\List\Commands\Filter\ImageDTOFactory;
use Romchik38\Site2\Application\Article\List\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Article\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\List\RepositoryInterface;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Category\VO\Name as CategoryName;

use function implode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private DatabaseSqlInterface $database,
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
            $models[] = $this->createFromRow($row, $searchCriteria->language);
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
     * @param array<string,string|null> $row
     * */
    private function createFromRow(
        array $row,
        string $language
    ): ArticleDTO {
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

        $categories = $this->createCategories($rawIdentifier, $language);

        return new ArticleDTO(
            $rawIdentifier,
            $rawName,
            $rawShortDescription,
            $rawDescription,
            $categories,
            new DateTime($rawCreatedAt),
            $this->imageDtoFactory->create($rawImgId, $rawImgPath, $rawImgDescription)
        );
    }

    /**
     * @throws RepositoryException
     * @return array<int,CategoryDTO>
     */
    private function createCategories(string $articleId, string $language): array
    {
        $categories = [];

        $query  = $this->categoryQuery();
        $params = [$language, $articleId];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        foreach ($rows as $row) {
            $rawId = $row['category_id'] ?? null;
            if ($rawId === null) {
                throw new RepositoryException('Article category id is invalid');
            }
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Article category name is invalid');
            }

            try {
                $id           = new CategoryId($rawId);
                $name         = new CategoryName($rawName);
                $categories[] = new CategoryDTO($id, $name);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }

        return $categories;
    }

    private function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT article.identifier,
        article_translates.name,
        article_translates.short_description,
        article_translates.description,
        article_translates.created_at,
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

    private function categoryQuery(): string
    {
        return <<<'QUERY'
        SELECT category_translates.category_id,
            category_translates.name
        FROM category_translates,
            article_category
        WHERE category_translates.language = $1 AND
            article_category.category_id = category_translates.category_id AND
            article_category.article_id = $2
        QUERY;
    }
}
