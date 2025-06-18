<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Banner;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Banner\BannerService\Exceptions\NoSuchBannerException;
use Romchik38\Site2\Application\Banner\BannerService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\BannerService\RepositoryInterface;
use Romchik38\Site2\Domain\Banner\Banner;
use Romchik38\Site2\Domain\Banner\Entities\Image;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Banner\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function createImage(ImageId $id): Image
    {
        $paramId = (string) $id;
        $query   = $this->imageCreateQuery();
        $params  = [$paramId];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new RepositoryException(sprintf('Banner image with id %s does not exist', $paramId));
        }

        if ($count > 1) {
            throw new RepositoryException(sprintf('Banner image with id %s has duplicates', $paramId));
        }

        $rawActive = $rows[0]['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Banner image active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        return new Image($id, $active);
    }

    public function getById(BannerId $id): Banner
    {
        $paramId = (string) $id;
        $query   = $this->defaultSelectQuery();
        $params  = [$paramId];
        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new NoSuchBannerException(sprintf('Banner with id %s does not exist', $paramId));
        }

        if ($count > 1) {
            throw new RepositoryException(sprintf('Banner with id %s hs duplicates', $paramId));
        }

        return $this->createFromRow($id, $rows[0]);
    }

    public function delete(Banner $model): void
    {
        $bannerId = $model->id;
        if ($bannerId === null) {
            throw new RepositoryException('Could not delete banner, id is empty');
        }

        $query  = $this->deleteQuery();
        $params = [$bannerId()];

        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function save(Banner $model): void
    {
        $bannerId = $model->id;
        if ($bannerId === null) {
            throw new RepositoryException('Could not save banner, id is empty');
        }

        $bannerName = $model->name;

        if ($model->active) {
            $bannerActive = 't';
        } else {
            $bannerActive = 'f';
        }

        $query  = $this->mainSaveQuery();
        $params = [$bannerName(), $bannerActive, $bannerId()];

        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function add(Banner $model): BannerId
    {
        $id = $model->id;
        if ($id !== null) {
            throw new RepositoryException('Could not add banner, id is not empty');
        }

        $name    = $model->name;
        $imageId = $model->image->id;

        $query  = $this->mainAddQuery();
        $params = [$name(), $imageId()];

        try {
            $rows = $this->database->queryParams($query, $params);
            if (count($rows) !== 1) {
                throw new RepositoryException('Banner add query must return 1 row');
            }
            $rawBannerId = $rows[0]['identifier'] ?? null;
            if ($rawBannerId === null) {
                throw new RepositoryException('Banner add query does not return identifier');
            }
            try {
                return BannerId::fromString($rawBannerId);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    /** @param array<string,string|null> $row */
    private function createFromRow(BannerId $bannerId, array $row): Banner
    {
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
            $name    = new Name($rawName);
            $imageId = ImageId::fromString($rawImageIdentifier);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new Banner(
            $bannerId,
            $active,
            $name,
            new Image($imageId, $imageActive)
        );
    }

    private function defaultSelectQuery(): string
    {
        return <<<'QUERY'
        SELECT banner.active,
            banner.name,
            banner.img_id,
            img.active as image_active
        FROM banner,
            img
        WHERE banner.img_id = img.identifier AND
            banner.identifier = $1
        QUERY;
    }

    private function imageCreateQuery(): string
    {
        return <<<'QUERY'
        SELECT img.active
        FROM img
        WHERE img.identifier = $1
        QUERY;
    }

    private function mainSaveQuery(): string
    {
        return <<<'QUERY'
        UPDATE banner 
        SET name = $1, active = $2
        WHERE identifier = $3
        QUERY;
    }

    /** @todo refactor */
    private function mainAddQuery(): string
    {
        return <<<'QUERY'
        INSERT INTO banner (name, img_id)
        VALUES ($1, $2)
        RETURNING identifier;
        QUERY;
    }

    /** @todo refactor */
    private function deleteQuery(): string
    {
        return <<<'QUERY'
        DELETE FROM banner 
        WHERE identifier = $1
        QUERY;
    }
}
