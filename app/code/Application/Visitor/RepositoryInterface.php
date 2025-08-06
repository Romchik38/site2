<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Visitor;

use Romchik38\Site2\Domain\Visitor\Visitor;

interface RepositoryInterface
{
    /** @throws RepositoryException */
    public function delete(): void;

    /** @throws RepositoryException */
    public function getVisitor(): Visitor;

    /** @throws RepositoryException */
    public function save(Visitor $model): void;
}
