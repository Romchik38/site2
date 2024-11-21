<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Img;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Domain\Img\VO\Id;

/** @todo implement */
final class ImgRepository implements ImgRepositoryInterface
{
    public function __construct(
        protected readonly DatabaseInterface $database
    ) {}

    public function getById(Id $id): Img {}

    protected function getQuery(): string {
        return <<<QUERY
        SELECT img.identifier,
            img.name,
            img.author_id,
            img_translates.description
        QUERY;
    }
}
