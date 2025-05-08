<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminList;

use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Author\AdminList\RepositoryException;
use Romchik38\Site2\Application\Author\AdminList\RepositoryInterface;
use Romchik38\Site2\Application\Author\AdminList\SearchCriteria;
use Romchik38\Site2\Application\Author\AdminList\View\AuthorDto;

use function implode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function list(SearchCriteria $searchCriteria): array
    {
        $expression = [];
        $params     = [];
        $paramCount = 0;

        /** ORDER BY */
        $orderBy = new OrderBy(
            ($searchCriteria->orderByField)(),
            ($searchCriteria->orderByDirection)()
        );

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
        $params[]     = ($searchCriteria->offset)();

        $query = sprintf('%s %s', $this->defaultQuery(), implode(' ', $expression));

        $rows = $this->database->queryParams($query, $params);

        $models = [];

        foreach ($rows as $row) {
            $models[] = $this->createFromRow($row);
        }
        return $models;
    }

    /** @param array<string,string> $row */
    private function createFromRow(array $row): AuthorDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Author id is invalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Author active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Author name is invalid');
        }

        return new AuthorDto(
            $rawIdentifier,
            $rawName,
            $active
        );
    }

    private function defaultQuery(): string
    {
        return <<<QUERY
        SELECT author.identifier,
            author.active,
            author.name
        FROM author
        QUERY;
    }

    public function totalCount(): int
    {
        $query = 'SELECT count(author.identifier) as count FROM author';

        $rows = $this->database->queryParams($query, []);

        $firstElem = $rows[0];
        $count     = $firstElem['count'];

        return (int) $count;
    }
}
