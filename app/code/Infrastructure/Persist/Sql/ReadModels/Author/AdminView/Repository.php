<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminView;

use Romchik38\Site2\Application\Author\AdminView\RepositoryInterface;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Application\Author\AdminView\View\AuthorDto;

final class Repository implements RepositoryInterface
{
    
    public function getById(AuthorId $id): AuthorDto
    {
        return new AuthorDto();
    }
}
