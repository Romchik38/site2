<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Session\Visitor;

use InvalidArgumentException;
use Romchik38\Site2\Application\Visitor\RepositoryException;
use Romchik38\Site2\Application\Visitor\RepositoryInterface;
use Romchik38\Site2\Domain\Visitor\Visitor;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CouldNotGenerateException;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

use function serialize;
use function unserialize;

final class Repository implements RepositoryInterface
{
    public function __construct(
        /** @todo replace with server session */
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator
    ) {
    }

    public function delete(): void
    {
        $this->session->setData(Site2SessionInterface::VISITOR_FIELD, '');
        $this->session->logout();
    }

    public function getVisitor(): Visitor
    {
        $sessionVisitorData = $this->session->getData(Site2SessionInterface::VISITOR_FIELD);
        if ($sessionVisitorData === null || $sessionVisitorData === '') {
            $model = $this->create();
            $this->save($model);
        } else {
            $model = unserialize($sessionVisitorData);
        }

        if (! $model instanceof Visitor) {
            throw new RepositoryException('Session visitor data is invalid');
        }

        return $model;
    }

    public function save(Visitor $model): void
    {
        $this->session->setData(Site2SessionInterface::VISITOR_FIELD, serialize($model));
    }

    private function create(): Visitor
    {
        try {
            $csrfToken = $this->csrfTokenGenerator->asBase64();
        } catch (CouldNotGenerateException $e) {
            throw new RepositoryException($e->getMessage());
        }

        try {
            $visitor = new Visitor(new CsrfToken($csrfToken));
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return $visitor;
    }
}
