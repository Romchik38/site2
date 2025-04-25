<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\TranslateService;

use Romchik38\Site2\Application\Translate\TranslateService\Exceptions\NoSuchTranslateException;
use Romchik38\Site2\Application\Translate\TranslateService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\Translate\Translate;
use Romchik38\Site2\Domain\Translate\VO\Identifier;

interface RepositoryInterface
{
    /**
     * @throws NoSuchTranslateException
     * @throws RepositoryException
     * */
    public function getById(Identifier $id): Translate;

    /** @throws RepositoryException */
    public function deleteById(Identifier $id): void;

    /** @throws RepositoryException */
    public function save(Translate $model): void;

    /** @throws RepositoryException */
    public function add(Translate $model): void;
}
