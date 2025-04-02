<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView;

use Romchik38\Site2\Application\Image\AdminView\View\Dto;
use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Domain\Image\VO\Id;

final class AdminViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {   
    }

    /** 
     * @throws NoSuchImageException
     * @throws RepositoryException
     */
    public function find(Id $id): Dto
    {
        return $this->repository->getById($id);
    } 
}