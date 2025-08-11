<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Visitor;

use InvalidArgumentException;
use Romchik38\Site2\Application\Visitor\View\VisitorDto;
use Romchik38\Site2\Application\VisitorServiceInterface;
use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\VO\Message;

final class VisitorService implements VisitorServiceInterface
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /** @todo test */
    /**
     * @throws InvalidArgumentException
     * @throws RepositoryException
     * */
    public function changeMessage(string $message): void
    {
        $messageVo      = new Message($message);
        $model          = $this->repository->getVisitor();
        $model->message = $messageVo;
        $this->repository->save($model);
    }

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
