<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Image;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Domain\Image\Image;
use Romchik38\Site2\Domain\Image\ImageRepositoryInterface;
use Romchik38\Site2\Domain\Image\RepositoryException;
use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\Entities\Author;
use Romchik38\Site2\Domain\Author\VO\AuthorId;

final class Repository implements ImageRepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {  
    }

    public function getById(Id $id): Image
    {
        $query = $this->getByIdQuery();
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
                $id()
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Image with id %s has duplicates',
                $id()
            ));
        }

        $row = $rows[0];

        $model = $this->createModel($id, $row);
        return $model;
    }

    /**
     * @param array<string,string> $row 
     * @throws InvalidArgumentException
     * @throws RepositoryException
     * */
    private function createModel(Id $id, array $row): Image
    {
        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Image active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Image name is invalid');
        }

        $author = $this->createAuthor($row);

        /** @todo implement */
        return Image::load(
            $id,
            $active,
            $rawName,
            $author
        );
    }

    /** 
     * @param array<string,string> $row
     * @throws RepositoryException
     * */
    private function createAuthor(array $row): Author
    {
        $rawId = $row['author_id'] ?? null;
        if ($rawId === null) {
            throw new RepositoryException('Image author id is invalid');
        }
        
        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Image author active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        return new Author(new AuthorId($rawId), $active);
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
            SELECT img.active,
                img.name,
                img.author_id,
                img.path
                author.active as author_active
            FROM img,
                author
            WHERE img.identifier = $1
                AND img.author_id = author.identifier
        QUERY;
    }
}