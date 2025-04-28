<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ImageCache\ImageCacheView;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\ImageCache\View\Commands\Find\ViewDTO;
use Romchik38\Site2\Application\ImageCache\View\Exceptions\NoSuchImageCacheException;
use Romchik38\Site2\Application\ImageCache\View\Exceptions\RepositoryException;
use Romchik38\Site2\Application\ImageCache\View\RepositoryInterface;
use Romchik38\Site2\Domain\ImageCache\VO\Data;
use Romchik38\Site2\Domain\ImageCache\VO\Key;
use Romchik38\Site2\Domain\ImageCache\VO\Type;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        protected readonly DatabaseSqlInterface $database,
    ) {
    }

    public function getByKey(Key $key): ViewDTO
    {
        $query = <<<'QUERY'
            SELECT img_cache.data,
                img_cache.type
            FROM img_cache 
            WHERE img_cache.key = $1
        QUERY;

        $params = [$key()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 1) {
            $row     = $rows[0];
            $rawType = $row['type'] ?? null;
            if ($rawType === null) {
                throw new RepositoryException('Cache param type is invalid');
            }
            $rawData = $row['data'] ?? null;
            if ($rawData === null) {
                throw new RepositoryException('Cache param data is invalid');
            }
            try {
                $type = new Type($rawType);
                $data = new Data($rawData);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
            return new ViewDTO($type, $data);
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
