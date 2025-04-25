<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\View;

use Romchik38\Site2\Application\Translate\View\Exceptions\CouldNotFindException;
use Romchik38\Site2\Application\Translate\View\Exceptions\NoSuchTranslateException;
use Romchik38\Site2\Application\Translate\View\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Translate\View\View\TranslateDto;
use Romchik38\Site2\Domain\Translate\VO\Identifier;

final class ViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFindException - On database error.
     * @throws NoSuchTranslateException
     * */
    public function find(Identifier $id): TranslateDto
    {
        try {
            return $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        }
    }
}
