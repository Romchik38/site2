<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use Romchik38\Site2\Domain\Audio\Audio;
use Romchik38\Site2\Domain\Audio\Entities\Translate;
use Romchik38\Site2\Domain\Audio\VO\Id;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException
     * */
    public function add(Audio $model): Audio;

    /**
     * @throws RepositoryException
     * */
    public function addTranslate(Id $id, Translate $translate): void;

    /**
     * @throws RepositoryException
     * */
    public function delete(Audio $model): void;

    /**
     * @throws NoSuchAudioException
     * @throws RepositoryException
     * */
    public function getById(Id $id): Audio;

    /**
     * @throws RepositoryException
     * */
    public function save(Audio $model): void;
}
