<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\AdminList;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Image\AdminImageListService\RepositoryException;
use Romchik38\Site2\Application\Image\AdminImageListService\RepositoryInterface;
use Romchik38\Site2\Application\Image\AdminImageListService\SearchCriteria;
use Romchik38\Site2\Application\Image\AdminImageListService\View\ImageDto;
use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Image\VO\Name as ImageName;
use Romchik38\Site2\Domain\Image\VO\Path;

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
        $params[]     = (string) $searchCriteria->offset;

        $query = sprintf('%s %s', $this->defaultQuery(), implode(' ', $expression));

        $rows = $this->database->queryParams($query, $params);

        $models = [];

        foreach ($rows as $row) {
            $models[] = $this->createFromRow($row);
        }
        return $models;
    }

    /** @param array<string,string|null> $row */
    private function createFromRow(array $row): ImageDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Image id is invalid');
        }

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

        $rawAuthorName = $row['author_name'] ?? null;
        if ($rawAuthorName === null) {
            throw new RepositoryException('Image author name is invalid');
        }

        $rawPath = $row['path'] ?? null;
        if ($rawPath === null) {
            throw new RepositoryException('Image author name is invalid');
        }

        try {
            $imageId    = ImageId::fromString($rawIdentifier);
            $imageName  = new ImageName($rawName);
            $authorName = new AuthorName($rawAuthorName);
            $path       = new Path($rawPath);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new ImageDto(
            $imageId,
            $active,
            $imageName,
            $authorName,
            $path
        );
    }

    private function defaultQuery(): string
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
