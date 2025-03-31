<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\AdminList;

use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Image\AdminImageListService\RepositoryException;
use Romchik38\Site2\Application\Image\AdminImageListService\RepositoryInterface;
use Romchik38\Site2\Application\Image\AdminImageListService\SearchCriteria;
use Romchik38\Site2\Application\Image\AdminImageListService\View\ImageDto;

use function implode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        protected readonly DatabaseSqlInterface $database
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
        $params[]     = (string) $searchCriteria->offset;

        $query = sprintf('%s %s', $this->defaultQuery(), implode(' ', $expression));

        $rows = $this->database->queryParams($query, $params);

        $models = [];

        foreach ($rows as $row) {
            $models[] = $this->createFromRow($row);
        }
        return $models;
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): ImageDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Image id is ivalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Image active is ivalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Image name is ivalid');
        }

        $rawAuthorName = $row['author_name'] ?? null;
        if ($rawAuthorName === null) {
            throw new RepositoryException('Image author name is ivalid');
        }

        $rawPath = $row['path'] ?? null;
        if ($rawPath === null) {
            throw new RepositoryException('Image author name is ivalid');
        }

        return new ImageDto(
            $rawIdentifier,
            $active,
            $rawName,
            $rawAuthorName,
            $rawPath
        );
    }

    protected function defaultQuery(): string
    {
        return <<<QUERY
        SELECT img.identifier,
            img.active,
            img.name,
            (SELECT author.name 
                FROM author WHERE author.identifier = img.author_id
            ) as author_name,
            img.path
        FROM img 
        QUERY;
    }

    public function totalCount(): int
    {
        $query = 'SELECT count(img.identifier) as count FROM img';

        $rows = $this->database->queryParams($query, []);

        $firstElem = $rows[0];
        $count     = $firstElem['count'];

        return (int) $count;
    }
}
