<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ImgConverter;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Errors\RepositoryConsistencyException;
use Romchik38\Site2\Application\ImgConverter\View\ImgView;
use Romchik38\Site2\Application\ImgConverter\View\ImgViewRepositoryInterface;
use Romchik38\Site2\Domain\Img\VO\Id;
use Romchik38\Site2\Domain\Img\VO\Path;

final class ImgViewRepository implements ImgViewRepositoryInterface
{
    public function __construct(
        protected readonly DatabaseInterface $database,
    ) {}

    public function getById(Id $id): ImgView
    {
        $query = <<<QUERY
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
                Id::fromString($row['identifier']),
                Path::fromString($row['path'])
            );
        } elseif ($count === 0) {
            throw new NoSuchEntityException(
                sprintf('img with id %s not exist', $id())
            );
        } else {
            throw new RepositoryConsistencyException(
                sprintf('img with id %s has duplicates', $id)
            );
        }
    }
}
