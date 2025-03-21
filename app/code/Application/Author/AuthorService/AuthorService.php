<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AuthorService;

use Romchik38\Site2\Domain\Author\RepositoryInterface;

final class AuthorService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {   
    }

    
}