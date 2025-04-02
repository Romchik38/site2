<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\AdminView;

use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Image\AdminView\RepositoryException;
use Romchik38\Site2\Application\Image\AdminView\RepositoryInterface;
use Romchik38\Site2\Application\Image\AdminView\View\AuthorDto;
use Romchik38\Site2\Application\Image\AdminView\View\Dto;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Path;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(Id $id): Dto
    {
        $query  = $this->getByIdQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new NoSuchImageException(sprintf(
                'Image with id %s not exist',
                (string) $id
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Image with id %s has duplicates',
                (string) $id
            ));
        }

        $rawImage = $rows[0];

        return $this->createFromRow($rawImage);
    }

    /** @param array<string,string> $row */
    private function createFromRow(array $row): Dto
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

        $rawPath = $row['path'] ?? null;
        if ($rawPath === null) {
            throw new RepositoryException('Image author name is ivalid');
        }

        // Author
        $rawAuthorId = $row['author_id'] ?? null;
        if ($rawAuthorId === null) {
            throw new RepositoryException('Image author id is ivalid');
        }

        $rawAuthorName = $row['author_name'] ?? null;
        if ($rawAuthorName === null) {
            throw new RepositoryException('Image author name is ivalid');
        }

        $rawAuthorActive = $row['active'] ?? null;
        if ($rawAuthorActive === null) {
            throw new RepositoryException('Image author active is ivalid');
        }
        if ($rawAuthorActive === 't') {
            $activeAuthor = true;
        } else {
            $activeAuthor = false;
        }

        $author = new AuthorDto(
            new AuthorId($rawAuthorId),
            new AuthorName($rawAuthorName),
            $activeAuthor
        );

        return new Dto(
            new Id((int) $rawIdentifier),
            $active,
            new Name($rawName),
            new Path($rawPath),
            $author
        );
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
            SELECT img.identifier,
                img.active,
                img.name,
                img.author_id,
                img.path,
                author.name as author_name,
                author.active as author_active
            FROM img,
                author
            WHERE img.identifier = $1
                AND img.author_id = author.identifier
        QUERY;
    }
}
