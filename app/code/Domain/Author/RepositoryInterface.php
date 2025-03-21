<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author;

interface RepositoryInterface
{
    public function save(Author $model): Author;
}
