<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Page\AdminList;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Server\Persist\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Page\AdminList\RepositoryException;
use Romchik38\Site2\Application\Page\AdminList\RepositoryInterface;
use Romchik38\Site2\Application\Page\AdminList\View\PageDto;
use Romchik38\Site2\Domain\Page\VO\Id as PageId;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\Url;

use function implode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function filter(SearchCriteria $searchCriteria): array
    {
        $expression = [];
        $params     = [];
        $paramCount = 0;

        $params[] = ($searchCriteria->languageId)();
        $paramCount++;

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
        $params[]     = ($searchCriteria->offset)();

        $query = sprintf('%s %s', $this->defaultQuery(), implode(' ', $expression));

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
        $query = 'SELECT count(id) as count FROM page';

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
    private function createFromRow(array $row): PageDto
    {
        $rawIdentifier = $row['id'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Page id is invalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Page active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawUrl = $row['url'] ?? null;
        if ($rawUrl === null) {
            throw new RepositoryException('Page url is invalid');
        }

        $rawName = $row['name'] ?? null;

        $name = null;
        try {
            $id  = PageId::fromString($rawIdentifier);
            $url = new Url($rawUrl);
            if ($rawName !== null) {
                $name = new Name($rawName);
            }
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new PageDto($id, $active, $name, $url);
    }

    private function defaultQuery(): string
    {
        return <<<'QUERY'
        WITH rows AS (
            SELECT page_id, name 
            FROM page_translates
            WHERE language = $1
        )
        SELECT page.id,
            page.active,
            page.url,
            rows.name
        FROM page LEFT JOIN rows
            ON page.id = rows.page_id
        QUERY;
    }
}
