<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Translate;

use Romchik38\Site2\Domain\Translate\VO\Identifier;

interface RepositoryInterface
{
    /**
     * @throws NoSuchTranslateException
     * @throws RepositoryException
     * */
    public function getById(Identifier $id): Translate;

    /** @throws CouldDeleteException */
    public function deleteById(Identifier $id): void;

    /** @throws CouldNotSaveException */
    public function save(Translate $model): Translate;

    /** @throws CouldNotSaveException */
    public function add(Translate $model): Translate;
}
