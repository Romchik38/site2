<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Language\List;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Language\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Language\List\RepositoryInterface;
use Romchik38\Site2\Application\Language\List\View\LanguageDto;
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

    /**
     * @throws RepositoryException
     * @param array<string,string> $row
     * */
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

        try {
            $id = new Identifier($rawIdentifier);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException(
                'Language list view repository:' . $e->getMessage()
            );
        }

        return new LanguageDto(
            $id,
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
