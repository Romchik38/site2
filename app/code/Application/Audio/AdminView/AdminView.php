<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminView;

use Romchik38\Site2\Application\Audio\AdminView\View\AudioDto;
use Romchik38\Site2\Domain\Audio\VO\Id;

final class AdminView
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFindException
     * @throws NoSuchAudioException
     * */
    public function find(Id $id): AudioDto
    {
        try {
            return $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        }
    }
}
