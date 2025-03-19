<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImgConverter\View;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Domain\Image\DuplicateIdException;
use Romchik38\Site2\Domain\Image\VO\Id;

interface ImgViewRepositoryInterface
{
    /**
     * @throws NoSuchEntityException
     * @throws DuplicateIdException - On duplicates.
     * */
    public function getById(Id $id): ImgView;
}
