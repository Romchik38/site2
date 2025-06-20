<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Banner\AdminView;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Banner\AdminView\Exceptions\NoSuchBannerException;
use Romchik38\Site2\Application\Banner\AdminView\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\AdminView\RepositoryInterface;
use Romchik38\Site2\Application\Banner\AdminView\View\BannerDto;
use Romchik38\Site2\Application\Banner\AdminView\View\ImageDto;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Banner\VO\Name;
use Romchik38\Site2\Domain\Banner\VO\Priority;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function find(BannerId $id): BannerDto
    {
        $paramId = (string) $id;
        $query   = $this->defaultQuery();
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

    /**
     * @throws RepositoryException
     * @param array<string,string|null> $row
     * */
    private function createFromRow(BannerId $bannerId, array $row): BannerDto
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

        $rawPriority = $row['priority'] ?? null;
        if ($rawPriority === null) {
            throw new RepositoryException('Banner priority is invalid');
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
            $name     = new Name($rawName);
            $imageId  = ImageId::fromString($rawImageIdentifier);
            $priority = Priority::fromString($rawPriority);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new BannerDto(
            $bannerId,
            $active,
            $name,
            new ImageDto($imageId, $imageActive),
            $priority
        );
    }

    private function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT banner.active,
            banner.name,
            banner.img_id,
            banner.priority,
            img.active as image_active
        FROM banner,
            img
        WHERE banner.img_id = img.identifier AND
            banner.identifier = $1
        QUERY;
    }
}
