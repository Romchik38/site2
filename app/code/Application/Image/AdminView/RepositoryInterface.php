<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView;

use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Application\Image\AdminView\View\Dto;
use Romchik38\Site2\Domain\Image\NoSuchImageException;

interface RepositoryInterface
{
    /**
     * @throws NoSuchImageException
     * @throws RepositoryException
     */
    public function getById(Id $id): Dto;
}
