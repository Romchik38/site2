<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminView;

use Romchik38\Site2\Application\Author\AdminView\View\AuthorDto;
use Romchik38\Site2\Domain\Author\VO\AuthorId;

interface RepositoryInterface
{
    /**
     * @throws NoSuchAuthorException
     * @throws RepositoryException
     * */
    public function getById(AuthorId $id): AuthorDto;
}
