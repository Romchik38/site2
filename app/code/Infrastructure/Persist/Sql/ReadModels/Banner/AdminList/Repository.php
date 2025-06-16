<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Banner\AdminList;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Banner\AdminList\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\AdminList\RepositoryInterface;
use Romchik38\Site2\Application\Banner\AdminList\View\BannerDto;
use Romchik38\Site2\Application\Banner\AdminList\View\ImageDto;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Banner\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

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

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Banner active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Banner name is invalid');
        }

        $rawImageIdentifier = $row['img_id'] ?? null;
        if ($rawImageIdentifier === null) {
            throw new RepositoryException('Banner image id is invalid');
        }

        $rawImageActive = $row['image_active'] ?? null;
        if ($rawImageActive === null) {
            throw new RepositoryException('Banner image active is invalid');
        }
        if ($rawImageActive === 't') {
            $imageActive = true;
        } else {
            $imageActive = false;
        }

        try {
            $id      = BannerId::fromString($rawIdentifier);
            $name    = new Name($rawName);
            $imageId = ImageId::fromString($rawImageIdentifier);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new BannerDto(
            $id,
            $active,
            $name,
            new ImageDto($imageId, $imageActive)
        );
    }

    private function defaultQuery(): string
    {
        return <<<QUERY
        SELECT banner.identifier,
            banner.active,
            banner.name,
            banner.img_id,
            img.active as image_active
        FROM banner,
            img
        WHERE banner.img_id = img.identifier
        QUERY;
    }
}
