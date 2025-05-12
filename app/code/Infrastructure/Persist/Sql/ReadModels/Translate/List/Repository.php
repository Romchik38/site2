<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Translate\List;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Server\Persist\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Translate\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Translate\List\RepositoryInterface;
use Romchik38\Site2\Application\Translate\List\SearchCriteria;
use Romchik38\Site2\Application\Translate\List\View\TranslateDto;
use Romchik38\Site2\Domain\Translate\VO\Identifier;

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
        $query = 'SELECT count(translate_keys.identifier) as count FROM translate_keys';

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
    private function createFromRow(array $row): TranslateDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Translate id is invalid');
        }

        try {
            $id = new Identifier($rawIdentifier);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }
        return new TranslateDto($id);
    }

    private function defaultQuery(): string
    {
        return <<<QUERY
        SELECT translate_keys.identifier
        FROM translate_keys
        QUERY;
    }
}
