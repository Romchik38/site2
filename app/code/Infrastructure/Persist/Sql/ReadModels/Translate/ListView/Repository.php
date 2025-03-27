<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Translate\ListView;

use Romchik38\Server\Models\Sql\DatabaseInterface;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Translate\ListView\RepositoryException;
use Romchik38\Site2\Application\Translate\ListView\RepositoryInterface;
use Romchik38\Site2\Application\Translate\ListView\SearchCriteria;
use Romchik38\Site2\Application\Translate\ListView\View\TranslateDto;
use Romchik38\Site2\Domain\TranslateKey\VO\Identifier;

use function implode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        protected readonly DatabaseInterface $database
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
    protected function createFromRow(array $row): TranslateDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Translate id is ivalid');
        }

        return new TranslateDto(
            new Identifier($rawIdentifier),
        );
    }

    protected function defaultQuery(): string
    {
        return <<<QUERY
        SELECT translate_keys.identifier
        FROM translate_keys
        QUERY;
    }

    public function totalCount(): int
    {
        $query = 'SELECT count(translate_keys.identifier) as count FROM translate_keys';

        $rows = $this->database->queryParams($query, []);

        $firstElem = $rows[0];
        $count     = $firstElem['count'];

        return (int) $count;
    }
}
