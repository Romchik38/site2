<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminView;

use Romchik38\Site2\Application\Page\AdminView\View\PageDto;
use Romchik38\Site2\Domain\Page\VO\Id;

interface RepositoryInterface
{
    /**
     * @throws NoSuchPageException
     * @throws RepositoryException - On invalid database data.
     * */
    public function getById(Id $id): PageDto;
}
