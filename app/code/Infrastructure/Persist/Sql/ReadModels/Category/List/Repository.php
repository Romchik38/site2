<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Category\List;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Category\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Category\List\RepositoryInterface;
use Romchik38\Site2\Application\Category\List\View\CategoryDto;
use Romchik38\Site2\Domain\Category\VO\Description as CategoryDescription;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Category\VO\Name as CategoryName;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function list(LanguageId $languageId): array
    {
        $query  = $this->listQuery();
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
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Category description is invalid');
            }
            $rawTotalCount = $row['total_count'] ?? null;
            if ($rawTotalCount === null) {
                throw new RepositoryException('Category total count is invalid');
            }

            try {
                $id          = new CategoryId($rawId);
                $name        = new CategoryName($rawName);
                $description = new CategoryDescription($rawName);
                $dtos[]      = new CategoryDto($id, $name, $description, (int) $rawTotalCount);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }
        return $dtos;
    }

    private function listQuery(): string
    {
        return <<<'QUERY'
            SELECT category.identifier,
                category_translates.name,
                category_translates.description,
                (
                    SELECT count(article_category.article_id)
                    FROM article_category,
                        category as c2
                    WHERE article_category.category_id = category.identifier AND
                        article_category.category_id = c2.identifier AND
                        c2.active = 't'
                ) as total_count
            FROM category_translates,
                category
            WHERE category_translates.language = $1 AND
                category.identifier = category_translates.category_id AND
                category.active = 't'
        QUERY;
    }
}
