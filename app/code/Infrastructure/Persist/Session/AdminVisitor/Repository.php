<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Session\AdminVisitor;

use InvalidArgumentException;
use Romchik38\Server\Http\Utils\Session\SessionInterface;
use Romchik38\Site2\Application\AdminVisitor\RepositoryException;
use Romchik38\Site2\Application\AdminVisitor\RepositoryInterface;
use Romchik38\Site2\Domain\AdminVisitor\AdminVisitor;
use Romchik38\Site2\Domain\AdminVisitor\VO\CsrfToken;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CouldNotGenerateException;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

use function serialize;
use function unserialize;

final class Repository implements RepositoryInterface
{
    private const VISITOR_FIELD = 'admin_visitor';

    public function __construct(
        private readonly SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator
    ) {
    }

    public function delete(): void
    {
        $this->session->setData(self::VISITOR_FIELD, '');
        $this->session->logout();
    }

    public function getVisitor(): AdminVisitor
    {
        $sessionVisitorData = $this->session->getData(self::VISITOR_FIELD);
        if ($sessionVisitorData === null || $sessionVisitorData === '') {
            $model = $this->create();
            $this->save($model);
        } else {
            $model = unserialize($sessionVisitorData);
        }

        if (! $model instanceof AdminVisitor) {
            throw new RepositoryException('Session admin visitor data is invalid');
        }

        return $model;
    }

    public function save(AdminVisitor $model): void
    {
        $this->session->setData(self::VISITOR_FIELD, serialize($model));
    }

    private function create(): AdminVisitor
    {
        try {
            $csrfToken = $this->csrfTokenGenerator->asBase64();
        } catch (CouldNotGenerateException $e) {
            throw new RepositoryException($e->getMessage());
        }

        try {
            $visitor = new AdminVisitor(
                null,
                new CsrfToken($csrfToken)
            );
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return $visitor;
    }
}
