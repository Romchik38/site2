<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Banner\List;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Banner\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\List\RepositoryInterface;
use Romchik38\Site2\Application\Banner\List\View\BannerDto;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Banner\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Image\VO\Path;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function list(): array
    {
        $query = $this->defaultQuery();
        try {
            $rows = $this->database->queryParams($query, []);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $models = [];
        foreach ($rows as $row) {
            $models[] = $this->createFromRow($row);
        }
        return $models;
    }

    /**
     * @throws RepositoryException
     * @param array<string,string|null> $row
     * */
    private function createFromRow(array $row): BannerDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Banner id is invalid');
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Banner name is invalid');
        }

        $rawImageIdentifier = $row['img_id'] ?? null;
        if ($rawImageIdentifier === null) {
            throw new RepositoryException('Banner image id is invalid');
        }

        $rawImagePath = $row['path'] ?? null;
        if ($rawImagePath === null) {
            throw new RepositoryException('Banner image path is invalid');
        }

        try {
            $id        = BannerId::fromString($rawIdentifier);
            $name      = new Name($rawName);
            $imageId   = ImageId::fromString($rawImageIdentifier);
            $imagePath = new Path($rawImagePath);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new BannerDto($id, $name, $imageId, $imagePath);
    }

    private function defaultQuery(): string
    {
        return <<<QUERY
        SELECT banner.identifier,
            banner.name,
            banner.img_id,
            img.path
        FROM banner,
            img
        WHERE banner.active = 't' AND
            img.identifier = banner.img_id
        QUERY;
    }
}
