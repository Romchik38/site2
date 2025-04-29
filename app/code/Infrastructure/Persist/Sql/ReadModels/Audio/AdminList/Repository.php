<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminList;

use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Audio\AdminList\RepositoryException;
use Romchik38\Site2\Application\Audio\AdminList\RepositoryInterface;
use Romchik38\Site2\Application\Audio\AdminList\SearchCriteria;
use Romchik38\Site2\Application\Audio\AdminList\View\AudioDto;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;

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
    private function createFromRow(array $row): AudioDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Audio id is invalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Audio active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Audio name is invalid');
        }

        return new AudioDto(
            Id::fromString($rawIdentifier),
            $active,
            new Name($rawName)
        );
    }

    private function defaultQuery(): string
    {
        return <<<QUERY
        SELECT audio.identifier,
            audio.active,
            audio.name
        FROM audio
        QUERY;
    }

    public function totalCount(): int
    {
        $query = 'SELECT count(audio.identifier) as count FROM audio';

        $rows = $this->database->queryParams($query, []);

        $firstElem = $rows[0];
        $count     = $firstElem['count'];

        return (int) $count;
    }
}
