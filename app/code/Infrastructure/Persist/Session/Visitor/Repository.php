<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Session\Visitor;

use Romchik38\Site2\Application\Visitor\RepositoryException;
use Romchik38\Site2\Application\Visitor\RepositoryInterface;
use Romchik38\Site2\Domain\Visitor\Visitor;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;

use function serialize;
use function unserialize;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly Site2SessionInterface $session,
    ) {
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
        return new Visitor(null, false);
    }
}
