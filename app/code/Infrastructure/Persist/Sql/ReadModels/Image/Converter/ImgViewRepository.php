<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\Converter;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgView;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgViewRepositoryInterface;
use Romchik38\Site2\Domain\Image\DuplicateIdException;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Path;

use function count;
use function sprintf;

final class ImgViewRepository implements ImgViewRepositoryInterface
{
    public function __construct(
        protected readonly DatabaseInterface $database,
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
            return new ImgView(
                new Id($row['identifier']),
                new Path($row['path'])
            );
        } elseif ($count === 0) {
            throw new NoSuchEntityException(
                sprintf('img with id %s not exist', $id())
            );
        } else {
            throw new DuplicateIdException(
                sprintf('img with id %s has duplicates', $id())
            );
        }
    }
}
