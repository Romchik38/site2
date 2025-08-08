<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminVisitor;

use Romchik38\Site2\Domain\AdminVisitor\AdminVisitor;

interface RepositoryInterface
{
    /** @throws RepositoryException */
    public function delete(): void;

    /** @throws RepositoryException */
    public function getVisitor(): AdminVisitor;

    /** @throws RepositoryException */
    public function save(AdminVisitor $model): void;
}
