<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminVisitor;

use Romchik38\Site2\Application\AdminVisitor\View\VisitorDto;
use Romchik38\Site2\Domain\AdminUser\VO\Username;

final class AdminVisitorService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /** @throws RepositoryException */
    public function getVisitor(): VisitorDto
    {
        $model = $this->repository->getVisitor();
        return new VisitorDto(
            $model->username,
            $model->csrfTocken
        );
    }

    /** @throws RepositoryException */
    public function updateUserName(Username $username): void
    {
        $model           = $this->repository->getVisitor();
        $model->username = $username;
        $this->repository->save($model);
    }

    /** @throws RepositoryException */
    public function logout(): void
    {
        $this->repository->delete();
    }
}
