<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Category\View;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Server\Persist\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Category\View\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Category\View\Exceptions\NoSuchCategoryException;
use Romchik38\Site2\Application\Category\View\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Category\View\RepositoryInterface;
use Romchik38\Site2\Application\Category\View\View\ArticleDto;
use Romchik38\Site2\Application\Category\View\View\ArticleDtoFactory;
use Romchik38\Site2\Application\Category\View\View\CategoryDto;
use Romchik38\Site2\Application\Category\View\View\CategoryIdNameDto;
use Romchik38\Site2\Application\Category\View\View\ImageDtoFactory;
use Romchik38\Site2\Domain\Category\VO\Description as CategoryDescription;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Category\VO\Name as CategoryName;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;
use function implode;
use function json_decode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private DatabaseSqlInterface $database,
        private ArticleDtoFactory $articleDtoFactory,
        private ImageDtoFactory $imageDtoFactory
    ) {
    }

    public function find(SearchCriteria $searchCriteria): CategoryDto
    {
        $languageParam = (string) $searchCriteria->languageId;
        $categoryParam = (string) $searchCriteria->categoryId;
        $query         = $this->categoryQuery();
        $params        = [$languageParam, $categoryParam];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $rowCount = count($rows);
        if ($rowCount === 0) {
            throw new NoSuchCategoryException(sprintf(
                'Active category with id %s and language %s not exist',
                $categoryParam,
                $languageParam
            ));
        }
        if ($rowCount > 1) {
            throw new RepositoryException(sprintf(
                'Category with id %s has more than one count',
                $categoryParam
            ));
        }

        return $this->createFromRow($rows[0], $searchCriteria);
    }

    public function listIdNames(LanguageId $languageId): array
    {
        $query  = $this->listIdNameQuery();
        $params = [(string) $languageId];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $dtos = [];
        foreach ($rows as $row) {
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Category name is invalid');
            }
            $rawId = $row['identifier'] ?? null;
            if ($rawId === null) {
                throw new RepositoryException('Category id is invalid');
            }

            try {
                $id     = new CategoryId($rawId);
                $name   = new CategoryName($rawName);
                $dtos[] = new CategoryIdNameDto($id, $name);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }
        return $dtos;
    }

    /**
     * @param array<string,string|null> $row
     */
    private function createFromRow(array $rowCategory, SearchCriteria $searchCriteria): CategoryDto
    {
        $rawName = $rowCategory['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Category name is invalid');
        }

        $rawDescription = $rowCategory['description'] ?? null;
        if ($rawDescription === null) {
            throw new RepositoryException('Category description is invalid');
        }

        $rawTotalCount = $rowCategory['total_count'] ?? null;
        if ($rawTotalCount === null) {
            throw new RepositoryException('Category total count is invalid');
        }

        try {
            $name        = new CategoryName($rawName);
            $description = new CategoryDescription($rawDescription);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $articles = $this->createArticles($searchCriteria);

        return new CategoryDto(
            $searchCriteria->categoryId,
            $name,
            $description,
            $articles,
            (int) $rawTotalCount
        );
    }

    /**
     * @return array<int,ArticleDTO>
     * */
    private function createArticles(SearchCriteria $searchCriteria): array
    {
        $expression = [];
        $params     = [
            (string) $searchCriteria->languageId,
            (string) $searchCriteria->categoryId,
        ];
        $paramCount = 2;

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
            $this->articlesQuery(),
            implode(' ', $expression)
        );

        try {
            $articleRows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $articles = [];

        foreach ($articleRows as $articleRow) {
            $articles[] = $this->createArticle($articleRow);
        }

        return $articles;
    }

    /** @todo refactor */
    /**
     * @throws RepositoryException
     * @param array<string,string|null> $row
     * */
    private function createArticle(array $row): ArticleDto
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

    private function categoryQuery(): string
    {
        return <<<'QUERY'
            SELECT category_translates.name,
                category_translates.description,
                (
                    SELECT count(article_category.article_id)
                    FROM article_category,
                        category 
                    WHERE article_category.category_id = $2 AND
                        article_category.category_id = category.identifier AND
                        category.active = 't'
                ) as total_count
            FROM category_translates,
                category
            WHERE category_translates.language = $1 AND
                category.identifier = category_translates.category_id AND
                category.active ='t' AND
                category.identifier = $2
        QUERY;
    }

    private function articlesQuery(): string
    {
        return <<<'QUERY'
        WITH categories AS
        (
            SELECT category.active, 
                category_translates.category_id,
                category_translates.name
            FROM category_translates,
                category
            WHERE category_translates.language = $1 AND
                category.identifier = category_translates.category_id AND
                category.active ='t'
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
            img_translates,
            article_category
        WHERE 
            article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = $1
            AND article.img_id = img.identifier
            AND img_translates.img_id = article.img_id
            AND img_translates.language = $1
            AND article_category.article_id = article.identifier
            AND article_category.category_id = $2
        QUERY;
    }

    private function listIdNameQuery(): string
    {
        return <<<'QUERY'
            SELECT category.identifier,
                category_translates.name
            FROM category_translates,
                category
            WHERE category_translates.language = $1 AND
                category.identifier = category_translates.category_id
        QUERY;
    }
}
