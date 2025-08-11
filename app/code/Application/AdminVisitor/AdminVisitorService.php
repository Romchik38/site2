<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\AdminVisitor;

use InvalidArgumentException;
use Romchik38\Site2\Application\AdminVisitor\View\VisitorDto;
use Romchik38\Site2\Application\VisitorServiceException;
use Romchik38\Site2\Application\VisitorServiceInterface;
use Romchik38\Site2\Domain\AdminUser\VO\Username;
use Romchik38\Site2\Domain\AdminVisitor\VO\Message;

final class AdminVisitorService implements VisitorServiceInterface
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /** @throws VisitorServiceException */
    public function changeMessage(string $message): void
    {
        try {
            $messageVo      = new Message($message);
            $model          = $this->repository->getVisitor();
            $model->message = $messageVo;
            $this->repository->save($model);
        } catch (InvalidArgumentException $e) {
            throw new VisitorServiceException($e->getMessage());
        } catch (RepositoryException $e) {
            throw new VisitorServiceException($e->getMessage());
        }
    }

    /** @throws VisitorServiceException */
    public function getMessage(): ?string
    {
        try {
            $model          = $this->repository->getVisitor();
            $message        = $model->message;
            $model->message = null;
            $this->repository->save($model);
            if ($message === null) {
                return $message;
            } else {
                return $message();
            }
        } catch (RepositoryException $e) {
            throw new VisitorServiceException($e->getMessage());
        }
    }

    /** @throws VisitorServiceException */
    public function getVisitor(): VisitorDto
    {
        try {
            $model = $this->repository->getVisitor();
            return new VisitorDto(
                $model->username,
                $model->csrfTocken
            );
        } catch (RepositoryException $e) {
            throw new VisitorServiceException($e->getMessage());
        }
    }

    /** @throws RepositoryException */
    public function updateUserName(Username $username): void
    {
        $model           = $this->repository->getVisitor();
        $model->username = $username;
        $this->repository->save($model);
    }

    /** @throws VisitorServiceException */
    public function logout(): void
    {
        try {
            $this->repository->delete();
        } catch (RepositoryException $e) {
            throw new VisitorServiceException($e->getMessage());
        }
    }
}
