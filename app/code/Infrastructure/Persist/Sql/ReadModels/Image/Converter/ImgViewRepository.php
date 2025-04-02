<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\Converter;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Image\ImgConverter\RepositoryException;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgView;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgViewRepositoryInterface;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Path;

use function count;
use function sprintf;

final class ImgViewRepository implements ImgViewRepositoryInterface
{
    public function __construct(
        protected readonly DatabaseSqlInterface $database,
    ) {
    }

    public function getById(Id $id): ImgView
    {
        $query = <<<'QUERY'
        SELECT img.identifier,
            img.path
        FROM img 
        WHERE img.identifier = $1
        QUERY;

        $params = [$id()];

        $rows = $this->database->queryParams($query, $params);

        $count = count($rows);
        if ($count === 1) {
            $row = $rows[0];
            $rawId = $row['identifier'] ?? null;
            if ($rawId === null) {
                throw new RepositoryException('image identifier is invalid');
            }
            return new ImgView(
                new Id((int) $rawId),
                new Path($row['path'])
            );
        } elseif ($count === 0) {
            throw new NoSuchEntityException(
                sprintf('img with id %s not exist', $id())
            );
        } else {
            throw new RepositoryException(
                sprintf('img with id %s has duplicates', $id())
            );
        }
    }
}
