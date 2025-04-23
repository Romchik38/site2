<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Category;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Server\Models\Sql\DatabaseTransactionException;
use Romchik38\Site2\Application\Category\CategoryService\Exceptions\NoSuchCategoryException;
use Romchik38\Site2\Application\Category\CategoryService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Category\CategoryService\RepositoryInterface;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Category\Category;
use Romchik38\Site2\Domain\Category\Entities\Article;
use Romchik38\Site2\Domain\Category\Entities\Translate;
use Romchik38\Site2\Domain\Category\VO\Description;
use Romchik38\Site2\Domain\Category\VO\Identifier;
use Romchik38\Site2\Domain\Category\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;
use function json_decode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    /**
     * @throws NoSuchCategoryException
     * @throws RepositoryException
     * */
    public function getById(Identifier $id): Category
    {
        $idAsString = $id();
        $params     = [$idAsString];

        $query = $this->getByIdQuery();

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

    /**
     * @todo implement
     * @throws RepositoryException
     */
    public function deleteById(Identifier $id): void
    {
    }

    /**
     * @todo implement
     * @throws RepositoryException
     */
    public function save(Category $model): void
    {
        $categoryId = $model->getId();
        if ($model->isActive()) {
            $categoryActive = 't';
        } else {
            $categoryActive = 'f';
        }

        $mainSaveQuery = $this->mainSaveQuery();
        $params        = [$categoryActive, $categoryId()];

        $translates = $model->getTranslates();

        try {
            $this->database->transactionStart();
            $this->database->transactionQueryParams(
                $mainSaveQuery,
                $params
            );

            $this->database->transactionQueryParams(
                $this->translatesSaveQueryDelete(),
                [$categoryId()]
            );

            if (count($translates) > 0) {
                foreach ($translates as $translate) {
                    $this->database->transactionQueryParams(
                        $this->translatesSaveQueryInsert(),
                        [
                            $categoryId(),
                            (string) $translate->getLanguage(),
                            (string) $translate->getName(),
                            (string) $translate->getDescription(),
                        ]
                    );
                }
            }
            $this->database->transactionEnd();
        } catch (DatabaseTransactionException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException(sprintf(
                    'Transaction error: %s, transaction rollback success',
                    $e->getMessage()
                ));
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException(sprintf(
                    'Transaction error: %s, tried to rollback with error: %s',
                    $e->getMessage(),
                    $e2->getMessage()
                ));
            }
        } catch (QueryException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException(sprintf(
                    'Query error: %s, transaction rollback success',
                    $e->getMessage()
                ));
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException(sprintf(
                    'Query error: %s, tried to rollback with error: %s',
                    $e->getMessage(),
                    $e2->getMessage()
                ));
            }
        } catch (RepositoryException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException(sprintf(
                    'Repository error: %s, tried to rollback with error: %s',
                    $e->getMessage(),
                    $e2->getMessage()
                ));
            }
        }
    }

    /**
     * @todo implement
     * @throws RepositoryException
     */
    public function add(Category $model): Identifier
    {
    }

    /** @param array<string,string> $row */
    private function createFromRow(Identifier $id, array $row): Category
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

        $articles = $this->createArticles($id);

        $rawLanguages = $row['languages'] ?? null;
        if ($rawLanguages === null) {
            throw new RepositoryException('Category languages param is invalid');
        }
        $languages = $this->createLanguages($rawLanguages);

        $translates = $this->createTranslates($id);

        return Category::load(
            $id,
            $active,
            $articles,
            $languages,
            $translates
        );
    }

    /**
     * @throws RepositoryException - on database error.
     * @return array<int,Article>
     * */
    private function createArticles(Identifier $id): array
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
                $articles[] = new Article($id, $active);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }

        return $articles;
    }

    /**
     * @param string $rawLanguages - Json encoded array of strings
     * @return array<int,LanguageId>
     */
    protected function createLanguages(string $rawLanguages): array
    {
        $decodedLanguages = json_decode($rawLanguages);

        $data = [];
        foreach ($decodedLanguages as $language) {
            $data[] = new LanguageId($language);
        }
        return $data;
    }

    /**
     * @throws RepositoryException
     * @return array<int,Translate>
     * */
    protected function createTranslates(Identifier $id): array
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
                $translate    = new Translate(
                    new LanguageId($rawLanguage),
                    new Description($rawDescription),
                    new Name($rawName)
                );
                $translates[] = $translate;
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException(
                    'Category repository:' . $e->getMessage()
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

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
        SELECT category.identifier,
            category.active,
            array_to_json (
                array (SELECT language.identifier 
                    FROM language
                ) 
            ) as languages
        FROM category
        WHERE category.identifier = $1
        QUERY;
    }

    private function mainSaveQuery(): string
    {
        return <<<'QUERY'
            UPDATE category
            SET active = $1
            WHERE category.identifier = $2
        QUERY;
    }

    protected function translatesSaveQueryDelete(): string
    {
        return <<<'QUERY'
        DELETE FROM category_translates 
        WHERE category_translates.category_id = $1
        QUERY;
    }

    private function translatesSaveQueryInsert(): string
    {
        return <<<'QUERY'
        INSERT INTO category_translates (category_id, language, name, description)
        VALUES ($1, $2, $3, $4)
        QUERY;
    }
}
