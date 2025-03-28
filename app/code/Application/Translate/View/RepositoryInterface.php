<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\View;

use Romchik38\Site2\Application\Translate\View\View\TranslateDto;
use Romchik38\Site2\Domain\Translate\VO\Identifier;

interface RepositoryInterface
{
    /** 
     * @throws NoSuchAuthorException 
     * @throws RepositoryException - On any database error
     * */
    public function getById(Identifier $id): TranslateDto;
}
