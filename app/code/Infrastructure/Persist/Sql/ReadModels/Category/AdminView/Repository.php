<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Category\AdminView;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Category\AdminView\NoSuchCategoryException;
use Romchik38\Site2\Application\Category\AdminView\RepositoryException;
use Romchik38\Site2\Application\Category\AdminView\RepositoryInterface;
use Romchik38\Site2\Application\Category\AdminView\View\ArticleDto;
use Romchik38\Site2\Application\Category\AdminView\View\CategoryDto;
use Romchik38\Site2\Application\Category\AdminView\View\TranslateDto;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Category\VO\Description;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Category\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(CategoryId $id): CategoryDto
    {
        $idAsString = $id();
        $params     = [$idAsString];

        $query = $this->defaultQuery();

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $rowCount = count($rows);
        if ($rowCount === 0) {
            throw new NoSuchCategoryException(sprintf(
                'Category with id %s not exist',
                $idAsString
            ));
        }
        if ($rowCount > 1) {
            throw new RepositoryException(sprintf(
                'Category with id %s has duplicates',
                $idAsString
            ));
        }

        $row = $rows[0];

        return $this->createFromRow($id, $row);
    }

    /** @param array<string,string|null> $row */
    private function createFromRow(CategoryId $id, array $row): CategoryDto
    {
        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Category active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $articles   = $this->createArticles($id);
        $translates = $this->createTranslates($id);

        return new CategoryDto(
            $id,
            $active,
            $articles,
            $translates
        );
    }

    /**
     * @throws RepositoryException - on database error.
     * @return array<int,ArticleDto>
     * */
    private function createArticles(CategoryId $id): array
    {
        $query  = $this->articleQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $articles = [];

        foreach ($rows as $row) {
            $rawIdentifier = $row['identifier'] ?? null;
            if ($rawIdentifier === null) {
                throw new RepositoryException('Category article id is invalid');
            }

            $rawActive = $row['active'] ?? null;
            if ($rawActive === null) {
                throw new RepositoryException('Category article active is invalid');
            }
            if ($rawActive === 't') {
                $active = true;
            } else {
                $active = false;
            }

            try {
                $id         = new ArticleId($rawIdentifier);
                $articles[] = new ArticleDto($id, $active);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }

        return $articles;
    }

    /**
     * @throws RepositoryException
     * @return array<int,TranslateDto>
     * */
    private function createTranslates(CategoryId $id): array
    {
        $translates = [];

        $params = [$id()];
        $query  = $this->translatesQuery();

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Category translates language param is invalid');
            }
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Category translates description param is invalid');
            }
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Category translates name param is invalid');
            }

            try {
                $translate    = new TranslateDto(
                    new LanguageId($rawLanguage),
                    new Name($rawName),
                    new Description($rawDescription)
                );
                $translates[] = $translate;
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException(
                    'Category admin view repository:' . $e->getMessage()
                );
            }
        }

        return $translates;
    }

    private function translatesQuery(): string
    {
        return <<<'QUERY'
        SELECT category_translates.language,
            category_translates.name,
            category_translates.description
        FROM category_translates
        WHERE category_translates.category_id = $1
        QUERY;
    }

    private function articleQuery(): string
    {
        return <<<'QUERY'
        SELECT article.identifier,
            article.active
        FROM article, article_category
        WHERE article_category.article_id = article.identifier
            AND article_category.category_id = $1
        QUERY;
    }

    private function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT category.identifier,
            category.active
        FROM category
        WHERE category.identifier = $1
        QUERY;
    }
}
