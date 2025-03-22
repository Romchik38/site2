<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Author;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Domain\Author\Author;
use Romchik38\Site2\Domain\Author\NoSuchAuthorException;
use Romchik38\Site2\Domain\Author\RepositoryInterface;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Author\RepositoryException;
use Romchik38\Site2\Domain\Author\DuplicateIdException;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseInterface $database
    ) {   
    }

    public function getById(AuthorId $id): Author
    {
        $params = [$id()];
        $query = $this->defaultQuery();

        $rows = $this->database->queryParams($query, $params);
        
        $rowsCount = count($rows);
        if ($rowsCount === 0) {
            throw new NoSuchAuthorException(sprintf(
                'Author with is %s not exist',
                $id()
            ));
        }
        if ($rowsCount > 1) {
            throw new DuplicateIdException(sprintf(
                'Author with is %s has duplicates',
                $id()
            ));
        }

        $model = $this->createFromRow($rows[0]);
        return $model;
    }
    
    /** @todo implement */
    public function save(Author $model): Author
    {
        return $model;
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): Author
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Author id is ivalid');
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Author name is ivalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Author active is ivalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }
        
        return Author::load(
            new AuthorId($rawIdentifier),
            new Name($rawName),
            $active,
            [],
            [],
            [],
            []
        );
    }

    
    protected function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT author.identifier,
            author.name,
            author.active
        FROM author
        WHERE author.identifier = $1
        QUERY;
    }
}