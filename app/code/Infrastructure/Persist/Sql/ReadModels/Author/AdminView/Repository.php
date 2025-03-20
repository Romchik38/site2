<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminView;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Application\Author\AdminView\RepositoryInterface;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Application\Author\AdminView\View\AuthorDto;
use Romchik38\Site2\Application\Author\AdminView\RepositoryException;
use Romchik38\Site2\Domain\Author\NoSuchAuthorException;
use Romchik38\Site2\Domain\Author\DuplicateIdException;

use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseInterface $database
    ) {   
    }
    
    public function getById(AuthorId $id): AuthorDto
    {
        $idAsString = $id();
        $params = [$idAsString];

        $query = $this->defaultQuery();

        $rows = $this->database->queryParams($query, $params);
        $rowCount = count($rows);
        if ($rowCount === 0) {
            throw new NoSuchAuthorException(sprintf(
                'Author with id %s not exist',
                $idAsString
            ));
        }
        if ($rowCount > 1) {
            throw new DuplicateIdException(sprintf(
                'Author with id %s has duplicates',
                $idAsString
            ));
        }

        $firstRow = $rows[0];
        return $this->createFromRow($firstRow);
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): AuthorDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Author id is ivalid');
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

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Author name is ivalid');
        }
        
        return new AuthorDto(
            $rawIdentifier,
            $rawName,
            $active
        );
    }

    protected function defaultQuery(): string
    {
        return <<<QUERY
        SELECT author.identifier,
            author.active,
            author.name
        FROM author
        WHERE author.identifier = $1
        QUERY;
    }
}
