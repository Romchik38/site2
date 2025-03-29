<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\View;

use Romchik38\Site2\Application\Translate\View\View\TranslateDto;
use Romchik38\Site2\Domain\Translate\NoSuchTranslateException;
use Romchik38\Site2\Domain\Translate\VO\Identifier;

final class ViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws NoSuchTranslateException
     * @throws RepositoryException - On database error.
     * */
    public function find(Identifier $id): TranslateDto
    {
        return $this->repository->getById($id);
    }
}
