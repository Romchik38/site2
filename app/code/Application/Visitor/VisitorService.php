<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Visitor;

use InvalidArgumentException;
use Romchik38\Site2\Application\Visitor\View\VisitorDto;
use Romchik38\Site2\Application\VisitorServiceException;
use Romchik38\Site2\Application\VisitorServiceInterface;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\VO\Message;

final class VisitorService implements VisitorServiceInterface
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws VisitorServiceException
     * */
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
    public function clearMessage(): void
    {
        try {
            $model          = $this->repository->getVisitor();
            $model->message = null;
            $this->repository->save($model);
        } catch (RepositoryException $e) {
            throw new VisitorServiceException($e->getMessage());
        }
    }

    /** @throws RepositoryException */
    public function acceptTerms(): void
    {
        $model = $this->repository->getVisitor();
        $model->acceptWithTerms();
        $this->repository->save($model);
    }

    /** @throws VisitorServiceException */
    public function getVisitor(): VisitorDto
    {
        try {
            $model = $this->repository->getVisitor();
            return new VisitorDto(
                $model->username,
                $model->isAcceptedTerms,
                $model->csrfTocken,
                $model->message,
                $model->getVisitedArticles()
            );
        } catch (RepositoryException $e) {
            throw new VisitorServiceException($e->getMessage());
        } catch (InvalidArgumentException $e) {
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

    /** @throws VisitorServiceException */
    public function updateArticleView(ArticleId $id): void
    {
        $visitor = $this->repository->getVisitor();
        $visitor->markArticleAsVisited($id);
        try {
            $this->repository->save($visitor);
        } catch (RepositoryException $e) {
            throw new VisitorServiceException($e->getMessage());
        }
    }
}
