<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView;

use Romchik38\Site2\Application\Image\AdminView\View\Dto;
use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Domain\Image\VO\Id;

interface RepositoryInterface
{
    /**
     * @throws NoSuchImageException
     * @throws RepositoryException
     */
    public function getById(Id $id): Dto;

    /**
     * @throws RepositoryException
     * @return array<int,AuthorDto>
     */
    public function listAuthors(): array;
}
