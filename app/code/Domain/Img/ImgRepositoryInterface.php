<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Img;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Domain\Img\VO\Id;

interface ImgRepositoryInterface
{
    /** @throws NoSuchEntityException */
    public function getById(Id $id): Img;
}
