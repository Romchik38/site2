<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Visitor;

final class VisitorService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /** @throws RepositoryException */
    public function acceptTerms(): void
    {
        $model = $this->repository->getVisitor();
        $model->acceptWithTerms();
        $this->repository->save($model);
    }

    /** @throws RepositoryException */
    public function checkAcceptTerms(): bool
    {
        $model = $this->repository->getVisitor();
        return $model->isAccepted;
    }
}
