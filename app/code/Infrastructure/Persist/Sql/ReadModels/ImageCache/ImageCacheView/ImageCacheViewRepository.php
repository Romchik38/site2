<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ImageCache\ImageCacheView;

use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\ImageCache\ImageCacheView\NoSuchImageCacheException;
use Romchik38\Site2\Application\ImageCache\ImageCacheView\RepositoryException;
use Romchik38\Site2\Application\ImageCache\ImageCacheView\View\ImageCacheViewDTO;
use Romchik38\Site2\Application\ImageCache\ImageCacheView\View\ImageCacheViewRepositoryInterface;
use Romchik38\Site2\Domain\ImageCache\VO\Data;
use Romchik38\Site2\Domain\ImageCache\VO\Key;
use Romchik38\Site2\Domain\ImageCache\VO\Type;

use function count;
use function sprintf;

final class ImageCacheViewRepository implements ImageCacheViewRepositoryInterface
{
    public function __construct(
        protected readonly DatabaseSqlInterface $database,
    ) {
    }

    public function getByKey(Key $key): ImageCacheViewDTO
    {
        $query = <<<'QUERY'
            SELECT img_cache.data,
                img_cache.type
            FROM img_cache 
            WHERE img_cache.key = $1
        QUERY;

        $params = [$key()];

        $rows = $this->database->queryParams($query, $params);

        $count = count($rows);
        if ($count === 1) {
            $row = $rows[0];
            return new ImageCacheViewDTO(
                new Type($row['type']),
                new Data($row['data'])
            );
        } elseif ($count === 0) {
            throw new NoSuchImageCacheException(
                sprintf('img with id %s not exist', $key())
            );
        } else {
            throw new RepositoryException(
                sprintf('img with id %s has duplicates', $key())
            );
        }
    }
}
