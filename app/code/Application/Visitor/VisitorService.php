<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Visitor;

use Romchik38\Site2\Application\Visitor\View\VisitorDto;
use Romchik38\Site2\Domain\User\VO\Username;

final class VisitorService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /** @todo test all path */
    /** @throws RepositoryException */
    public function acceptTerms(): void
    {
        $model = $this->repository->getVisitor();
        $model->acceptWithTerms();
        $this->repository->save($model);
    }

    /** @throws RepositoryException */
    public function getVisitor(): VisitorDto
    {
        $model = $this->repository->getVisitor();
        return new VisitorDto(
            $model->username,
            $model->isAcceptedTerms,
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
