<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ImgConverter;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Application\ImgConverter\View\ImgView;
use Romchik38\Site2\Application\ImgConverter\View\ImgViewRepositoryInterface;
use Romchik38\Site2\Domain\Img\VO\Id;

final class ImgViewRepository implements ImgViewRepositoryInterface
{
    public function __construct(
        protected readonly DatabaseInterface $database,
    ) {}

    public function getById(Id $id): ImgView
    {
        return new ImgView;
    }

    protected function getQuery(): string {
        return <<<QUERY
        SELECT img.identifier,

        QUERY;
    }
}
