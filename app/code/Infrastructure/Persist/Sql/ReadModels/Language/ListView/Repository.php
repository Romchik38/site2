<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Language\ListView;

use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Language\ListView\RepositoryException;
use Romchik38\Site2\Application\Language\ListView\RepositoryInterface;
use Romchik38\Site2\Application\Language\ListView\View\LanguageDto;
use Romchik38\Site2\Domain\Language\VO\Identifier;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getAll(): array
    {
        $query = $this->defaultQuery();

        try {
            $rows = $this->database->queryParams($query, []);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $list = [];
        foreach ($rows as $row) {
            $list[] = $this->createFromRow($row);
        }
        return $list;
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): LanguageDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Language id is invalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Language active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        return new LanguageDto(
            new Identifier($rawIdentifier),
            $active
        );
    }

    protected function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT language.identifier,
            language.active
        FROM language
        QUERY;
    }
}
